@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="page-header">
    <h1>Gestion des Utilisateurs</h1>
    <div class="breadcrumb">
        <a href="{{ route('administration.dashboard') }}">Tableau de bord</a> &raquo; Utilisateurs
    </div>
</div>

<!-- Statistiques des utilisateurs -->
<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon" style="background-color: var(--primary);">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
            <h3>Total Utilisateurs</h3>
            <p class="stat-number">{{ $users->count() }}</p>
            <small>Tous les utilisateurs</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--secondary);">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="card-content">
            <h3>Étudiants</h3>
            <p class="stat-number">{{ $users->where('role', 'etudiant')->count() }}</p>
            <small>Comptes étudiants</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--warning);">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="card-content">
            <h3>Administrateurs</h3>
            <p class="stat-number">{{ $users->where('role', 'admin')->count() }}</p>
            <small>Comptes admin</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon" style="background-color: var(--danger);">
            <i class="fas fa-calculator"></i>
        </div>
        <div class="card-content">
            <h3>Comptables</h3>
            <p class="stat-number">{{ $users->where('role', 'comptable')->count() }}</p>
            <small>Comptes comptables</small>
        </div>
    </div>
</div>

<div class="admin-section">
    <div class="section-header">
        <h3><i class="fas fa-list"></i> Liste des Utilisateurs</h3>
        <div class="header-actions">
            <div class="filter-buttons">
                <button class="btn btn-outline active" onclick="filterUsers('all')">Tous</button>
                <button class="btn btn-outline" onclick="filterUsers('etudiant')">Étudiants</button>
                <button class="btn btn-outline" onclick="filterUsers('admin')">Admins</button>
                <button class="btn btn-outline" onclick="filterUsers('comptable')">Comptables</button>
            </div>
            
            <!-- Nouveaux boutons d'importation Excel -->
            <div class="import-actions">
                <button onclick="downloadTemplate()" class="btn btn-success" title="Télécharger le modèle Excel">
                    <i class="fas fa-download"></i> Modèle Excel
                </button>
                <label class="btn btn-warning" title="Importer des utilisateurs depuis Excel">
                    <i class="fas fa-upload"></i> Importer Excel
                    <input type="file" id="excel-import" accept=".xlsx,.xls" style="display: none;" onchange="handleFileUpload(event)">
                </label>
            </div>
            
            <a href="{{ route('administration.utilisateurs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvel Utilisateur
            </a>
        </div>
    </div>

    @if($users && $users->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date création</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr data-role="{{ $user->role }}">
                            <td>
                                <div class="user-info">
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->role === 'etudiant' && $user->etudiant)
                                        <small>{{ $user->etudiant->matricule }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @switch($user->role)
                                    @case('etudiant')
                                        <span class="role-badge role-student">
                                            <i class="fas fa-graduation-cap"></i> Étudiant
                                        </span>
                                        @break
                                    @case('admin')
                                        <span class="role-badge role-admin">
                                            <i class="fas fa-user-shield"></i> Administrateur
                                        </span>
                                        @break
                                    @case('comptable')
                                        <span class="role-badge role-comptable">
                                            <i class="fas fa-calculator"></i> Comptable
                                        </span>
                                        @break
                                    @default
                                        <span class="role-badge role-default">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                @endswitch
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="status-badge status-success">
                                        <i class="fas fa-check-circle"></i> Vérifié
                                    </span>
                                @else
                                    <span class="status-badge status-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Non vérifié
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('administration.utilisateurs.show', $user->id) }}" class="btn-small btn-info" title="Voir profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('administration.utilisateurs.edit', $user->id) }}" class="btn-small btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('administration.utilisateurs.destroy', $user->id) }}" style="display: inline;">
                                             @csrf
                                             @method('DELETE')
                                                <button type="submit" class="btn-small btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')" title="Supprimer">
                                                   <i class="fas fa-trash"></i>
                                                </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h4>Aucun utilisateur trouvé</h4>
            <p>Commencez par créer des comptes utilisateurs.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer un utilisateur
            </a>
        </div>
    @endif
</div>

<!-- Modal d'importation Excel -->
<div id="import-modal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h3><i class="fas fa-file-excel text-success"></i> Prévisualisation de l'importation</h3>
            <button onclick="closeImportModal()" class="modal-close">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="import-info">
                <div class="alert alert-info">
                    <h4><i class="fas fa-info-circle"></i> Informations sur l'importation :</h4>
                    <ul>
                        <li><strong id="total-count">0</strong> utilisateur(s) détecté(s) dans le fichier</li>
                        <li><strong>Colonnes requises :</strong> Nom, Prénom, Email (obligatoires)</li>
                        <li><strong>Colonnes optionnelles :</strong> Téléphone, Date de naissance, Adresse, Rôle</li>
                        <li><strong>Noms d'utilisateur :</strong> générés automatiquement</li>
                        <li><strong>Mot de passe par défaut :</strong> <code>password123</code></li>
                        <li><strong>Rôles acceptés :</strong> etudiant, admin, comptable (défaut: etudiant)</li>
                    </ul>
                </div>
            </div>

            <div class="preview-section">
                <h4>Aperçu des données :</h4>
                <div class="table-container" style="max-height: 400px; overflow-y: auto;">
                    <table class="table" id="preview-table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Nom d'utilisateur</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Date naissance</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody id="preview-tbody">
                            <!-- Données dynamiques -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button onclick="closeImportModal()" class="btn btn-secondary">Annuler</button>
            <button id="confirm-import" onclick="confirmImport()" class="btn btn-success">
                <i class="fas fa-upload"></i> Confirmer l'importation
            </button>
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div id="progress-modal" class="modal-overlay" style="display: none;">
    <div class="modal-container modal-sm">
        <div class="modal-body text-center">
            <div class="loading-spinner"></div>
            <h4>Importation en cours...</h4>
            <p>Veuillez patienter pendant le traitement des utilisateurs.</p>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
            <small id="progress-text">0%</small>
        </div>
    </div>
</div>

<!-- Inclusion de la bibliothèque SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
// Variables globales pour l'importation
let importData = [];
let isProcessing = false;

// Fonction pour filtrer les utilisateurs (fonction existante préservée)
function filterUsers(role) {
    const rows = document.querySelectorAll('tbody tr[data-role]');
    const buttons = document.querySelectorAll('.filter-buttons .btn');

    // Reset button styles
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    rows.forEach(row => {
        if (role === 'all' || row.dataset.role === role) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Fonction pour télécharger le modèle Excel
function downloadTemplate() {
    const templateData = [
        {
            'Nom': 'Diop',
            'Prénom': 'Aminata',
            'Email': 'aminata.diop@example.com',
            'Téléphone': '77 123 45 67',
            'Date de naissance': '2000-05-15',
            'Adresse': 'Dakar, Sénégal',
            'Rôle': 'etudiant'
        },
        {
            'Nom': 'Fall',
            'Prénom': 'Mamadou',
            'Email': 'mamadou.fall@example.com',
            'Téléphone': '78 987 65 43',
            'Date de naissance': '1985-03-22',
            'Adresse': 'Thiès, Sénégal',
            'Rôle': 'comptable'
        },
        {
            'Nom': 'Ba',
            'Prénom': 'Fatou',
            'Email': 'fatou.ba@example.com',
            'Téléphone': '70 555 44 33',
            'Date de naissance': '1999-11-08',
            'Adresse': 'Saint-Louis, Sénégal',
            'Rôle': 'admin'
        }
    ];

    const ws = XLSX.utils.json_to_sheet(templateData);
    
    // Instructions
    const instructions = [
        ['INSTRUCTIONS POUR L\'IMPORTATION UTILISATEURS'],
        [''],
        ['Colonnes obligatoires:', 'Nom, Prénom, Email'],
        ['Colonnes optionnelles:', 'Téléphone, Date de naissance, Adresse, Rôle'],
        ['Rôles acceptés:', 'etudiant, admin, comptable'],
        ['Format date:', 'AAAA-MM-JJ (ex: 2000-12-25)'],
        ['Mot de passe par défaut:', 'password123'],
        ['Nom d\'utilisateur:', 'Généré automatiquement (ex: adiop)'],
        [''],
        ['IMPORTANT: Supprimez cet onglet avant l\'importation !'],
        [''],
        ['Après avoir rempli vos données :'],
        ['1. Supprimez cet onglet "Instructions"'],
        ['2. Gardez seulement l\'onglet "Utilisateurs"'],
        ['3. Importez le fichier via le bouton "Importer Excel"']
    ];

    const wsInstructions = XLSX.utils.aoa_to_sheet(instructions);
    
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Utilisateurs');
    XLSX.utils.book_append_sheet(wb, wsInstructions, 'Instructions');
    
    XLSX.writeFile(wb, 'modele_importation_utilisateurs.xlsx');
    
    showNotification('Modèle Excel téléchargé avec succès !', 'success');
}

// Fonction pour générer un nom d'utilisateur unique
function generateUsername(nom, prenom, existingUsernames) {
    const baseUsername = (prenom.charAt(0) + nom).toLowerCase()
        .replace(/[^a-z0-9]/g, '')
        .substring(0, 8);
    
    let username = baseUsername;
    let counter = 1;
    
    while (existingUsernames.includes(username)) {
        username = baseUsername + counter;
        counter++;
    }
    
    return username;
}

// Fonction pour traiter le fichier Excel
function handleFileUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (!file.name.match(/\.(xlsx|xls)$/)) {
        showNotification('Veuillez sélectionner un fichier Excel (.xlsx ou .xls)', 'error');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(sheet);

            if (jsonData.length === 0) {
                showNotification('Le fichier Excel est vide ou ne contient pas de données valides.', 'error');
                return;
            }

            // Récupérer les noms d'utilisateur existants (simulation)
            const existingUsernames = Array.from(document.querySelectorAll('tbody tr'))
                .map(row => row.querySelector('.user-info small')?.textContent)
                .filter(Boolean);

            // Traiter les données
            importData = jsonData.map((row, index) => {
                const nom = (row.Nom || row.nom || row.NOM || '').toString().trim();
                const prenom = (row.Prénom || row.prenom || row.PRENOM || row.Prenom || '').toString().trim();
                const email = (row.Email || row.email || row.EMAIL || '').toString().trim();
                const telephone = (row.Téléphone || row.telephone || row.TELEPHONE || row.Telephone || '').toString().trim();
                const dateNaissance = row['Date de naissance'] || row.date_de_naissance || row.DATE_DE_NAISSANCE || '';
                const adresse = (row.Adresse || row.adresse || row.ADRESSE || '').toString().trim();
                const role = (row.Rôle || row.role || row.ROLE || row.Role || 'etudiant').toString().toLowerCase();

                const nomDUtilisateur = nom && prenom ? 
                    generateUsername(nom, prenom, existingUsernames) : '';
                
                if (nomDUtilisateur) {
                    existingUsernames.push(nomDUtilisateur);
                }

                return {
                    nom,
                    prenom,
                    nom_d_utilisateur: nomDUtilisateur,
                    email,
                    telephone,
                    date_de_naissance: dateNaissance,
                    adresse,
                    role: ['etudiant', 'admin', 'comptable'].includes(role) ? role : 'etudiant',
                    password: 'password123',
                    password_confirmation: 'password123',
                    isValid: !!(nom && prenom && email && nomDUtilisateur)
                };
            });

            showImportPreview();
            
        } catch (error) {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la lecture du fichier Excel: ' + error.message, 'error');
        }
    };

    reader.readAsArrayBuffer(file);
    
    // Reset input
    event.target.value = '';
}

// Fonction pour afficher la prévisualisation
function showImportPreview() {
    document.getElementById('total-count').textContent = importData.length;
    
    const tbody = document.getElementById('preview-tbody');
    tbody.innerHTML = '';
    
    // Afficher les 10 premiers
    const previewData = importData.slice(0, 10);
    
    previewData.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.nom || '<span class="text-danger">Manquant</span>'}</td>
            <td>${user.prenom || '<span class="text-danger">Manquant</span>'}</td>
            <td><code class="username-preview">${user.nom_d_utilisateur || '<span class="text-danger">Erreur</span>'}</code></td>
            <td>${user.email || '<span class="text-danger">Manquant</span>'}</td>
            <td>${user.telephone || '-'}</td>
            <td class="small">${user.date_de_naissance || '-'}</td>
            <td>
                <span class="role-badge role-${user.role}">
                    <i class="fas fa-${user.role === 'admin' ? 'user-shield' : user.role === 'comptable' ? 'calculator' : 'graduation-cap'}"></i>
                    ${user.role}
                </span>
            </td>
            <td class="text-center">
                ${user.isValid ? 
                    '<i class="fas fa-check-circle text-success"></i>' : 
                    '<i class="fas fa-times-circle text-danger"></i>'
                }
            </td>
        `;
        tbody.appendChild(row);
    });
    
    if (importData.length > 10) {
        const moreRow = document.createElement('tr');
        moreRow.innerHTML = `
            <td colspan="8" class="text-center text-muted">
                <em>... et ${importData.length - 10} autre(s) utilisateur(s)</em>
            </td>
        `;
        tbody.appendChild(moreRow);
    }
    
    document.getElementById('import-modal').style.display = 'flex';
}

// Fonction pour fermer le modal
function closeImportModal() {
    if (isProcessing) return;
    document.getElementById('import-modal').style.display = 'none';
    importData = [];
}

// Fonction pour confirmer l'importation
async function confirmImport() {
    if (isProcessing || importData.length === 0) return;
    
    const validUsers = importData.filter(user => user.isValid);
    
    if (validUsers.length === 0) {
        showNotification('Aucun utilisateur valide trouvé pour l\'importation.', 'error');
        return;
    }

    if (!confirm(`Êtes-vous sûr de vouloir importer ${validUsers.length} utilisateur(s) ?`)) {
        return;
    }

    isProcessing = true;
    document.getElementById('import-modal').style.display = 'none';
    document.getElementById('progress-modal').style.display = 'flex';
    
    try {
        let imported = 0;
        const total = validUsers.length;
        
        for (const userData of validUsers) {
            // Préparer les données pour Laravel
            const formData = new FormData();
            formData.append('nom', userData.nom);
            formData.append('prenom', userData.prenom);
            formData.append('nom_d_utilisateur', userData.nom_d_utilisateur);
            formData.append('email', userData.email);
            formData.append('telephone', userData.telephone || '');
            formData.append('date_de_naissance', userData.date_de_naissance || '');
            formData.append('adresse', userData.adresse || '');
            formData.append('password', userData.password);
            formData.append('password_confirmation', userData.password_confirmation);
            formData.append('role', userData.role);

            // Envoyer vers Laravel
            const response = await fetch('{{ route("administration.utilisateurs.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            imported++;
            updateProgress(imported, total);
            
            if (!response.ok) {
                const errorData = await response.json();
                console.error('Erreur pour:', userData.email, errorData);
            }
            
            // Petite pause pour éviter la surcharge
            await new Promise(resolve => setTimeout(resolve, 100));
        }
        
        // Succès
        setTimeout(() => {
            document.getElementById('progress-modal').style.display = 'none';
            showNotification(`${imported} utilisateur(s) importé(s) avec succès !`, 'success');
            
            // Recharger la page pour voir les nouveaux utilisateurs
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }, 500);
        
    } catch (error) {
        document.getElementById('progress-modal').style.display = 'none';
        console.error('Erreur:', error);
        showNotification('Erreur lors de l\'importation: ' + error.message, 'error');
    }
    
    isProcessing = false;
}

// Fonction pour mettre à jour la barre de progression
function updateProgress(current, total) {
    const percentage = Math.round((current / total) * 100);
    document.getElementById('progress-fill').style.width = percentage + '%';
    document.getElementById('progress-text').textContent = `${percentage}% (${current}/${total})`;
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    // Créer la notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="notification-close">&times;</button>
    `;
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Suppression automatique après 5 secondes
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
</script>

<style>
.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

.import-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.btn-outline:hover,
.btn-outline.active {
    background: var(--primary);
    color: white;
}

.btn-success {
    background-color: var(--secondary);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: opacity 0.3s;
}

.btn-success:hover {
    opacity: 0.9;
}

.btn-warning {
    background-color: var(--warning);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: opacity 0.3s;
}

.btn-warning:hover {
    opacity: 0.9;
}

/* Styles pour les modals */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-container {
    background: white;
    border-radius: 8px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    width: 1000px;
}

.modal-sm {
    width: 400px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    margin: 0;
    color: var(--primary);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--gray);
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    color: var(--danger);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #eee;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.alert-info {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    color: #1565c0;
}

.alert ul {
    margin: 0.5rem 0 0 0;
    padding-left: 1.5rem;
}

.alert li {
    margin: 0.25rem 0;
}

.preview-section {
    margin-top: 1.5rem;
}

.preview-section h4 {
    margin-bottom: 1rem;
    color: var(--primary);
}

.username-preview {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.85rem;
    font-family: 'Courier New', monospace;
}

.text-danger {
    color: var(--danger) !important;
}

.text-success {
    color: var(--secondary) !important;
}

.text-muted {
    color: var(--gray) !important;
}

.small {
    font-size: 0.85rem;
}

/* Progress bar */
.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.progress-bar {
    width: 100%;
    height: 20px;
    background: #f0f0f0;
    border-radius: 10px;
    overflow: hidden;
    margin: 1rem 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--secondary), var(--primary));
    width: 0%;
    transition: width 0.3s ease;
}

/* Notifications */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 1100;
    min-width: 300px;
    transform: translateX(400px);
    transition: transform 0.3s ease;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    border-left: 4px solid var(--secondary);
}

.notification-error {
    border-left: 4px solid var(--danger);
}

.notification-info {
    border-left: 4px solid var(--primary);
}

.notification i {
    font-size: 1.2rem;
}

.notification-success i {
    color: var(--secondary);
}

.notification-error i {
    color: var(--danger);
}

.notification-info i {
    color: var(--primary);
}

.notification-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    color: var(--gray);
    margin-left: auto;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-close:hover {
    color: var(--danger);
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-info small {
    color: var(--gray);
    font-size: 0.8rem;
}

.role-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.role-student {
    background-color: rgba(52, 152, 219, 0.1);
    color: var(--primary);
    border: 1px solid rgba(52, 152, 219, 0.3);
}

.role-admin {
    background-color: rgba(243, 156, 18, 0.1);
    color: var(--warning);
    border: 1px solid rgba(243, 156, 18, 0.3);
}

.role-comptable {
    background-color: rgba(231, 76, 60, 0.1);
    color: var(--danger);
    border: 1px solid rgba(231, 76, 60, 0.3);
}

.role-default {
    background-color: rgba(149, 165, 166, 0.1);
    color: var(--gray);
    border: 1px solid rgba(149, 165, 166, 0.3);
}

.action-buttons {
    display: flex;
    gap: 0.3rem;
}

.btn-small {
    padding: 0.4rem 0.6rem;
    font-size: 0.8rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
}

.btn-info { 
    background: var(--primary); 
}

.btn-small.btn-warning { 
    background: var(--warning); 
}

.btn-small.btn-danger { 
    background: var(--danger); 
}

.btn-small:hover {
    opacity: 0.8;
}

.btn-secondary {
    background: var(--gray);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.btn-secondary:hover {
    opacity: 0.9;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .modal-container {
        width: 95%;
        max-width: none;
    }
    
    .header-actions {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }
    
    .filter-buttons,
    .import-actions {
        justify-content: center;
    }
    
    .import-actions {
        order: -1;
    }
}

@media (max-width: 768px) {
    .header-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-buttons {
        justify-content: center;
        flex-wrap: wrap;
    }

    .import-actions {
        justify-content: center;
        flex-wrap: wrap;
    }

    .table {
        font-size: 0.9rem;
    }

    .table th,
    .table td {
        padding: 0.5rem;
    }
    
    .modal-container {
        margin: 1rem;
        width: calc(100% - 2rem);
    }
    
    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 1rem;
    }
    
    .notification {
        right: 10px;
        left: 10px;
        min-width: auto;
        transform: translateY(-100px);
    }
    
    .notification.show {
        transform: translateY(0);
    }
    
    /* Table responsive pour mobile */
    .table-container {
        overflow-x: auto;
    }
    
    #preview-table {
        min-width: 800px;
    }
}

@media (max-width: 480px) {
    .btn,
    .btn-outline,
    .btn-success,
    .btn-warning {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }
    
    .filter-buttons .btn {
        flex: 1;
        text-align: center;
    }
    
    .import-actions .btn,
    .import-actions label {
        flex: 1;
        text-align: center;
        justify-content: center;
    }
    
    .modal-header h3 {
        font-size: 1.1rem;
    }
    
    .alert {
        padding: 0.75rem;
    }
    
    .alert ul {
        font-size: 0.9rem;
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .modal-footer .btn {
        width: 100%;
        margin: 0;
    }
}

/* Animation d'entrée pour le modal */
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.modal-container {
    animation: modalFadeIn 0.3s ease-out;
}

/* Styles pour les status badges (préservés de l'original) */
.status-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.status-success {
    background-color: rgba(46, 204, 113, 0.1);
    color: var(--secondary);
    border: 1px solid rgba(46, 204, 113, 0.3);
}

.status-warning {
    background-color: rgba(243, 156, 18, 0.1);
    color: var(--warning);
    border: 1px solid rgba(243, 156, 18, 0.3);
}

/* Amélioration de l'accessibilité */
.btn:focus,
.btn-outline:focus,
.btn-success:focus,
.btn-warning:focus,
.modal-close:focus,
.notification-close:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Animation pour les éléments de la liste lors du filtrage */
tbody tr {
    transition: opacity 0.2s ease, transform 0.2s ease;
}

tbody tr[style*="display: none"] {
    opacity: 0;
    transform: translateX(-10px);
}

/* Style pour les codes dans les alerts */
.alert code {
    background: rgba(0, 0, 0, 0.1);
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
}

/* Effet hover sur les lignes de tableau */
.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

/* Style pour les icônes dans les en-têtes */
.section-header h3 i {
    margin-right: 0.5rem;
    color: var(--primary);
}

.modal-header h3 i {
    margin-right: 0.5rem;
}

/* Amélioration des tooltips */
[title] {
    cursor: help;
}

/* Style pour les champs requis dans la prévisualisation */
.preview-table .text-danger {
    font-style: italic;
    font-weight: 500;
}

/* Spacing pour les éléments de la barre d'actions */
.header-actions > * {
    flex-shrink: 0;
}

/* Style pour les liens de breadcrumb */
.breadcrumb a {
    color: var(--primary);
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}
</style>

<!-- Meta tag CSRF pour les requêtes AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection