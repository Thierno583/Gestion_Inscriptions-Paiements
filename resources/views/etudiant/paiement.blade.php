@extends('layouts.app')

@section('title', 'Mes Paiements')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/paiements.css') }}">
<script src="https://js.stripe.com/v3/"></script>
@endpush

@section('content')
<div class="page-header">
    <h1>Mes Paiements</h1>
    <div class="breadcrumb">
        <a href="{{ route('etudiant.dashboard') }}">Tableau de bord</a> &raquo; Paiements
    </div>
</div>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon card-icon-success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="card-content">
            <h3>Paiements validés</h3>
            <p class="stat-number">{{ $paiements->where('statut', 'validé')->count() }}</p>
            <small>Total des paiements confirmés</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon card-icon-warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-content">
            <h3>En attente</h3>
            <p class="stat-number">{{ $paiements->where('statut', 'en_attente')->count() }}</p>
            <small>Paiements en cours de traitement</small>
        </div>
    </div>

    <div class="card">
        <div class="card-icon card-icon-primary">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-content">
            <h3>Montant total</h3>
            <p class="stat-number">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA</p>
            <small>Total de vos paiements</small>
        </div>
    </div>
</div>

<div class="paiements-container">
    <!-- Nouveau paiement -->
    <div class="payment-section">
        <div class="section-header">
            <h3><i class="fas fa-plus-circle"></i> Effectuer un nouveau paiement</h3>
        </div>

        @foreach($inscriptions as $inscription)
        <div class="inscription-payment-card" style="border: 1px solid #ddd; margin: 20px 0; padding: 20px; border-radius: 8px; background: #f9f9f9;">
            <h4 style="color: #007bff; margin-bottom: 15px;">
                <i class="fas fa-graduation-cap"></i> {{ $inscription->classe->libelle ?? 'Classe inconnue' }} - {{ $inscription->annee_academique ?? '' }}
            </h4>

<form id="form_{{ $inscription->id }}" method="POST" action="{{ route('paiement.orange.initiate') }}" class="individual-payment-form" novalidate>
                @csrf
                <input type="hidden" name="inscription_id" value="{{ $inscription->id }}">

                <div class="row" style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <label for="type_frais_{{ $inscription->id }}">Type de frais</label>
                        <select name="type_frais" id="type_frais_{{ $inscription->id }}" required>
                            <option value="">-- Choisissez un frais --</option>
                            <option value="inscription">Frais d'inscription</option>
                            <option value="mensualite">Frais de mensualité</option>
                            <option value="soutenance">Frais de soutenance</option>
                        </select>
                        <div class="invalid-feedback">Veuillez sélectionner un type de frais.</div>
                    </div>

                    <div class="form-group" style="flex: 1; min-width: 150px;">
                        <label for="montant_{{ $inscription->id }}">Montant (FCFA)</label>
                        <input type="number" name="amount" id="montant_{{ $inscription->id }}" readonly placeholder="Montant calculé" />
                    </div>

                    <div class="form-group" style="flex: 1; min-width: 200px;">
                        <label for="mode_paiement_{{ $inscription->id }}">Mode de paiement</label>
                        <select name="mode_paiement" id="mode_paiement_{{ $inscription->id }}" required>
                            <option value="" disabled selected>-- Choisir un mode --</option>
                            <option value="carte_bancaire">💳 Carte bancaire</option>
                            <option value="orange_money">📱 Orange Money</option>
                            <option value="virement">🏦 Virement bancaire</option>
                            <option value="especes">💵 Espèces</option>
                        </select>
                    </div>
                </div>

                <!-- Section Orange Money pour cette inscription -->
                <div id="orangeMoneySection_{{ $inscription->id }}" style="display:none; margin-top: 15px;">
                    <div class="form-group">
                        <label for="phone_number_{{ $inscription->id }}"><i class="fas fa-mobile-alt"></i> Numéro Orange Money</label>
                        <input type="text" name="phone_number" id="phone_number_{{ $inscription->id }}"
                               class="form-control" placeholder="7XXXXXXXX" pattern="7[0-9]{8}"
                               disabled>
                        <small class="form-text text-muted">Format: 7 suivi de 8 chiffres</small>
                    </div>
                </div>

                <!-- Section Stripe pour cette inscription -->
                <div id="stripeSection_{{ $inscription->id }}" style="display:none; margin-top: 15px;">
                    <div class="stripe-card-section">
                        <h5><i class="fas fa-credit-card"></i> Informations de la carte bancaire</h5>
                        <div class="stripe-elements-container">
                            <div id="card-element-{{ $inscription->id }}" class="stripe-card-element">
                                <!-- Stripe Elements will create form elements here -->
                            </div>
                            <div id="card-errors-{{ $inscription->id }}" class="stripe-error-message" role="alert"></div>
                        </div>
                        <div class="stripe-info">
                            <p><i class="fas fa-shield-alt"></i> Vos informations de paiement sont sécurisées par Stripe</p>
                            <p><i class="fas fa-lock"></i> Nous ne stockons pas vos données bancaires</p>
                        </div>
                    </div>
                </div>

                <div class="form-actions" style="margin-top: 15px;">
                    <button type="submit" class="btn btn-primary" id="submitBtn_{{ $inscription->id }}">
                        <i class="fas fa-paper-plane"></i> Payer cette inscription
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>

    <!-- debut ajout -->
    @if($inscriptions->count() > 0)
        {{-- Les inputs hidden sont maintenant dans le formulaire principal --}}
    @else
        <div class="alert alert-warning mt-3">
            <i class="fas fa-info-circle"></i>
            Votre inscription est encore <strong>en attente</strong>.
            Vous pourrez effectuer un paiement une fois qu'elle sera validée par l'administration.
        </div>
    @endif
    <!-- Fin ajout -->

    <!-- Script de gestion unifié -->
    <script>
    // Initialisation Stripe
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const stripeElements = {};
    const cardElements = {};

    document.addEventListener('DOMContentLoaded', function() {
        @foreach($inscriptions as $inscription)
        const modePaiement{{ $inscription->id }} = document.getElementById('mode_paiement_{{ $inscription->id }}');
        const orangeSection{{ $inscription->id }} = document.getElementById('orangeMoneySection_{{ $inscription->id }}');
        const stripeSection{{ $inscription->id }} = document.getElementById('stripeSection_{{ $inscription->id }}');
        const orangePhone{{ $inscription->id }} = document.getElementById('phone_number_{{ $inscription->id }}');
        const form{{ $inscription->id }} = document.getElementById('form_{{ $inscription->id }}');

        // Initialiser les éléments Stripe pour cette inscription
        stripeElements['{{ $inscription->id }}'] = stripe.elements();
        const cardElement{{ $inscription->id }} = stripeElements['{{ $inscription->id }}'].create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#424770',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#9e2146',
                },
            },
        });

        // Gestion de l'affichage conditionnel des sections de paiement
        modePaiement{{ $inscription->id }}.addEventListener('change', function() {
            // Masquer toutes les sections
            orangeSection{{ $inscription->id }}.style.display = 'none';
            stripeSection{{ $inscription->id }}.style.display = 'none';

            // Désactiver les champs
            orangePhone{{ $inscription->id }}.disabled = true;
            orangePhone{{ $inscription->id }}.removeAttribute('required');
            orangePhone{{ $inscription->id }}.value = '';

            if (this.value === 'orange_money') {
                orangeSection{{ $inscription->id }}.style.display = 'block';
                orangePhone{{ $inscription->id }}.disabled = false;
                orangePhone{{ $inscription->id }}.setAttribute('required', 'required');
            } else if (this.value === 'carte_bancaire' || this.value === 'virement') {
                stripeSection{{ $inscription->id }}.style.display = 'block';
                // Monter l'élément Stripe card si pas déjà fait
                if (!cardElements['{{ $inscription->id }}']) {
                    cardElement{{ $inscription->id }}.mount('#card-element-{{ $inscription->id }}');
                    cardElements['{{ $inscription->id }}'] = cardElement{{ $inscription->id }};

                    // Gestion des erreurs Stripe
                    cardElement{{ $inscription->id }}.on('change', function(event) {
                        const displayError = document.getElementById('card-errors-{{ $inscription->id }}');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                        } else {
                            displayError.textContent = '';
                        }
                    });
                }
            }
        });

        // Calcul des montants
        @if(isset($fraisParClasse[$inscription->classe->id]))
        const fraisClasse{{ $inscription->id }} = {!! json_encode($fraisParClasse[$inscription->classe->id]) !!};

        document.getElementById('type_frais_{{ $inscription->id }}').addEventListener('change', function() {
            const type = this.value;
            const montantField = document.getElementById('montant_{{ $inscription->id }}');
            montantField.value = fraisClasse{{ $inscription->id }}[type] || 0;
        });
        @endif

        // Validation du formulaire
        form{{ $inscription->id }}.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!form{{ $inscription->id }}.checkValidity()) {
                form{{ $inscription->id }}.classList.add('was-validated');
                return;
            }

            const btn = document.getElementById('submitBtn_{{ $inscription->id }}');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';

            const formData = new FormData(form{{ $inscription->id }});
            const modePaiementValue = formData.get('mode_paiement');

            if (modePaiementValue === 'carte_bancaire' || modePaiementValue === 'virement') {
                // Traitement Stripe
                handleStripePayment{{ $inscription->id }}(formData, btn);
            } else if (modePaiementValue === 'orange_money') {
                // Traitement Orange Money (code existant)
                handleOrangeMoneyPayment{{ $inscription->id }}(formData, btn);
            } else {
                // Autres modes de paiement
                handleOtherPayment{{ $inscription->id }}(formData, btn);
            }
        });

        // Fonction pour gérer le paiement Stripe
        function handleStripePayment{{ $inscription->id }}(formData, btn) {
            const cardElement = cardElements['{{ $inscription->id }}'];

            stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: '{{ Auth::user()->name }}',
                    email: '{{ Auth::user()->email }}',
                },
            }).then(function(result) {
                if (result.error) {
                    // Erreur lors de la création du payment method
                    document.getElementById('card-errors-{{ $inscription->id }}').textContent = result.error.message;
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Payer cette inscription';
                } else {
                    // Envoyer le payment method au serveur
                    const paymentData = {
                        payment_method_id: result.paymentMethod.id,
                        inscription_id: formData.get('inscription_id'),
                        montant: formData.get('amount'),
                        type_frais: formData.get('type_frais'),
                        mode_paiement: formData.get('mode_paiement')
                    };

                    fetch('{{ route("paiement.stripe.process") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(paymentData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (data.client_secret) {
                                // Confirmer le paiement si nécessaire
                                stripe.confirmCardPayment(data.client_secret).then(function(result) {
                                    if (result.error) {
                                        alert('Erreur: ' + result.error.message);
                                    } else {
                                        alert('Paiement réussi !');
                                        location.reload();
                                    }
                                });
                            } else {
                                alert('Paiement enregistré avec succès !');
                                location.reload();
                            }
                        } else {
                            throw new Error(data.message || 'Erreur lors du paiement');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur: ' + error.message);
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Payer cette inscription';
                    });
                }
            });
        }

        // Fonction pour gérer le paiement Orange Money
        function handleOrangeMoneyPayment{{ $inscription->id }}(formData, btn) {
            const phoneNumber = formData.get('phone_number');

            if (!phoneNumber) {
                alert('Veuillez saisir votre numéro Orange Money');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Payer cette inscription';
                return;
            }

            const orangeData = {
                inscription_id: formData.get('inscription_id'),
                phone_number: phoneNumber,
                amount: parseFloat(formData.get('amount'))
            };

            fetch('{{ route("paiement.orange.initiate") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(orangeData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.payment_url) {
                    window.location.href = data.payment_url;
                } else if (data.success) {
                    alert('Paiement enregistré avec succès !');
                    location.reload();
                } else {
                    throw new Error(data.message || 'Erreur lors du paiement');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur: ' + error.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Payer cette inscription';
            });
        }

        // Fonction pour les autres modes de paiement
        function handleOtherPayment{{ $inscription->id }}(formData, btn) {
            fetch(form{{ $inscription->id }}.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Paiement enregistré avec succès !');
                    location.reload();
                } else {
                    throw new Error(data.message || 'Erreur lors du paiement');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur: ' + error.message);
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Payer cette inscription';
            });
        }
        @endforeach
    });
    </script>

    <!-- Historique des paiements -->
    <div class="payment-section">
        <div class="section-header">
            <h3><i class="fas fa-history"></i> Historique de mes paiements</h3>
            @if($paiements->count() > 0)
                <span class="section-count">{{ $paiements->count() }} paiement(s)</span>
            @endif
        </div>

        @if($paiements->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Inscription</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Motif</th>
                            <th>Référence</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paiements as $paiement)
                        <tr>
                            <td>{{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $paiement->inscription->classe->libelle ?? 'N/A' }}</td>
                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                            <td>{{ ucfirst($paiement->motif) }}</td>
                            <td>{{ $paiement->reference_transaction }}</td>
                            <td>
                                @switch($paiement->statut)
                                    @case('validé')
                                    @case('valide')
                                        <span class="status-badge status-success">
                                            <i class="fas fa-check-circle"></i> Validé
                                        </span>
                                        @break
                                    @case('rejeté')
                                    @case('rejete')
                                        <span class="status-badge status-danger">
                                            <i class="fas fa-times-circle"></i> Rejeté
                                        </span>
                                        @break
                                    @case('en_attente')
                                        <span class="status-badge status-warning">
                                            <i class="fas fa-clock"></i> En attente
                                        </span>
                                        @break
                                    @default
                                        <span class="status-badge status-neutral">
                                            {{ ucfirst($paiement->statut) }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-small btn-info" onclick="viewPaiementDetails({{ $paiement->id }})" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if(in_array($paiement->statut, ['validé', 'valide']))
                                        <a href="{{ route('etudiant.paiements.recu', $paiement->id) }}" class="btn-small btn-primary" title="Télécharger reçu PDF" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
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
                <h4>Aucun paiement trouvé</h4>
                <p>Vous n'avez encore effectué aucun paiement. Utilisez le formulaire ci-dessus pour effectuer votre premier paiement.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de détails du paiement pour étudiant -->
<div id="paiementDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-receipt"></i> Détails de mon Paiement</h3>
            <span class="close" onclick="closePaiementModal()">&times;</span>
        </div>
        <div class="modal-body" id="paiementModalBody">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i> Chargement...
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la modal (code existant inchangé)
function viewPaiementDetails(id) {
    document.getElementById('paiementDetailsModal').style.display = 'block';

    document.getElementById('paiementModalBody').innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i> Chargement des détails...
        </div>
    `;

    fetch(`/etudiant/paiements/${id}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayEtudiantPaiementDetails(data.paiement);
            } else {
                document.getElementById('paiementModalBody').innerHTML = `
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        Erreur lors du chargement des détails
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('paiementModalBody').innerHTML = `
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    Erreur de connexion
                </div>
            `;
        });
}

function displayEtudiantPaiementDetails(paiement) {
    const modalBody = document.getElementById('paiementModalBody');

    modalBody.innerHTML = `
        <div class="student-details-container">
            <!-- Informations du paiement -->
            <div class="detail-section">
                <h4><i class="fas fa-credit-card"></i> Informations du Paiement</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Référence:</label>
                        <span class="reference-code">${paiement.reference_transaction}</span>
                    </div>
                    <div class="detail-item">
                        <label>Date de paiement:</label>
                        <span>${new Date(paiement.date_paiement).toLocaleDateString('fr-FR')}</span>
                    </div>
                    <div class="detail-item">
                        <label>Montant payé:</label>
                        <span class="amount-highlight">${new Intl.NumberFormat('fr-FR').format(paiement.montant)} FCFA</span>
                    </div>
                    <div class="detail-item">
                        <label>Mode de paiement:</label>
                        <span class="mode-badge">${formatModePayment(paiement.mode_paiement)}</span>
                    </div>
                    <div class="detail-item">
                        <label>Statut:</label>
                        <span class="status-badge ${getStatusClass(paiement.statut)}">
                            ${getStatusIcon(paiement.statut)} ${formatStatus(paiement.statut)}
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Type de frais:</label>
                        <span>${paiement.motif ? formatMotif(paiement.motif) : 'N/A'}</span>
                    </div>
                </div>
            </div>

            <!-- Informations de l'inscription -->
            <div class="detail-section">
                <h4><i class="fas fa-graduation-cap"></i> Inscription Concernée</h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Classe:</label>
                        <span>${paiement.inscription?.classe?.libelle || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Année académique:</label>
                        <span>${paiement.inscription?.annee_academique || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <label>Date d'inscription:</label>
                        <span>${paiement.inscription?.date_inscription ? new Date(paiement.inscription.date_inscription).toLocaleDateString('fr-FR') : 'N/A'}</span>
                    </div>
                </div>
            </div>

            ${paiement.statut === 'validé' || paiement.statut === 'valide' ? `
            <!-- Informations de validation -->
            <div class="detail-section validation-section">
                <h4><i class="fas fa-check-circle"></i> Paiement Validé</h4>
                <div class="validation-info">
                    <p><i class="fas fa-info-circle"></i> Votre paiement a été validé avec succès.</p>
                    ${paiement.comptable ? `
                    <p><strong>Validé par:</strong> ${paiement.comptable?.personne?.nom || 'N/A'} ${paiement.comptable?.personne?.prenom || ''}</p>
                    <p><strong>Date de validation:</strong> ${new Date(paiement.updated_at).toLocaleDateString('fr-FR')} à ${new Date(paiement.updated_at).toLocaleTimeString('fr-FR')}</p>
                    ` : ''}
                </div>
            </div>
            ` : ''}

            ${paiement.statut === 'en_attente' ? `
            <div class="detail-section pending-section">
                <h4><i class="fas fa-clock"></i> Paiement en Attente</h4>
                <div class="pending-info">
                    <p><i class="fas fa-info-circle"></i> Votre paiement est en cours de traitement par l'administration.</p>
                    <p>Vous recevrez une notification une fois qu'il sera validé.</p>
                </div>
            </div>
            ` : ''}

            <!-- Actions -->
            <div class="detail-actions">
                ${(paiement.statut === 'validé' || paiement.statut === 'valide') ? `
                <a href="/etudiant/paiements/${paiement.id}/recu" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download"></i> Télécharger le reçu PDF
                </a>
                ` : ''}
                <button type="button" class="btn btn-secondary" onclick="closePaiementModal()">
                    <i class="fas fa-times"></i> Fermer
                </button>
            </div>
        </div>
    `;
}

function closePaiementModal() {
    document.getElementById('paiementDetailsModal').style.display = 'none';
}

function formatModePayment(mode) {
    const modes = {
        'carte_bancaire': '💳 Carte bancaire',
        'mobile_money': '📱 Mobile Money',
        'orange_money': '🟠 Orange Money',
        'virement': '🏦 Virement',
        'especes': '💵 Espèces'
    };
    return modes[mode] || mode.replace('_', ' ');
}

function formatStatus(status) {
    const statuses = {
        'valide': 'Validé',
        'validé': 'Validé',
        'rejete': 'Rejeté',
        'rejeté': 'Rejeté',
        'en_attente': 'En attente'
    };
    return statuses[status] || status;
}

function formatMotif(motif) {
    const motifs = {
        'inscription': 'Frais d\'inscription',
        'mensualite': 'Frais de mensualité',
        'soutenance': 'Frais de soutenance'
    };
    return motifs[motif] || motif;
}

function getStatusClass(status) {
    const classes = {
        'valide': 'status-success',
        'validé': 'status-success',
        'rejete': 'status-danger',
        'rejeté': 'status-danger',
        'en_attente': 'status-warning'
    };
    return classes[status] || 'status-neutral';
}

function getStatusIcon(status) {
    const icons = {
        'valide': '<i class="fas fa-check-circle"></i>',
        'validé': '<i class="fas fa-check-circle"></i>',
        'rejete': '<i class="fas fa-times-circle"></i>',
        'rejeté': '<i class="fas fa-times-circle"></i>',
        'en_attente': '<i class="fas fa-clock"></i>'
    };
    return icons[status] || '<i class="fas fa-question-circle"></i>';
}

// Fermer la modal en cliquant à l'extérieur
window.onclick = function(event) {
    const modal = document.getElementById('paiementDetailsModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

<style>
/* Styles existants pour les badges de statut */
.status-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.status-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.status-neutral {
    background: #e2e3e5;
    color: #383d41;
    border: 1px solid #d6d8db;
}

/* Styles pour les boutons d'action */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-small {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    transition: all 0.3s;
}

.btn-info {
    background: #17a2b8;
}

.btn-primary {
    background: #007bff;
}

.btn-small:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}

/* Styles spécifiques pour Stripe */
.stripe-card-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 2px solid #007bff;
    margin-top: 15px;
}

.stripe-card-section h5 {
    color: #007bff;
    margin-bottom: 15px;
    font-size: 1.1rem;
    font-weight: 600;
}

.stripe-elements-container {
    margin-bottom: 15px;
}

.stripe-card-element {
    background: white;
    padding: 12px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: border-color 0.3s ease;
}

.stripe-card-element:hover,
.stripe-card-element:focus-within {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.stripe-error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 8px;
    min-height: 20px;
}

.stripe-info {
    background: #e7f3ff;
    padding: 10px;
    border-radius: 4px;
    border-left: 4px solid #007bff;
}

.stripe-info p {
    margin: 5px 0;
    font-size: 0.875rem;
    color: #495057;
}

.stripe-info i {
    color: #007bff;
    margin-right: 5px;
}

/* Modal Styles pour étudiant */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(3px);
}

.modal-content {
    background-color: white;
    margin: 2% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 1.5rem 2rem;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.3rem;
}

.close {
    color: white;
    font-size: 2rem;
    font-weight: bold;
    cursor: pointer;
    transition: opacity 0.3s;
    line-height: 1;
}

.close:hover {
    opacity: 0.7;
}

.modal-body {
    padding: 2rem;
}

.loading-spinner {
    text-align: center;
    padding: 3rem;
    color: #007bff;
    font-size: 1.1rem;
}

.loading-spinner i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

.error-message {
    text-align: center;
    padding: 2rem;
    color: #dc3545;
    font-size: 1.1rem;
}

.error-message i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

.student-details-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    border-left: 4px solid #007bff;
}

.validation-section {
    border-left-color: #28a745;
}

.pending-section {
    border-left-color: #ffc107;
}

.detail-section h4 {
    margin: 0 0 1rem 0;
    color: #333;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.detail-item label {
    font-weight: 600;
    color: #666;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-item span {
    font-size: 1rem;
    color: #333;
}

.amount-highlight {
    font-size: 1.3rem !important;
    font-weight: bold !important;
    color: #28a745 !important;
}

.reference-code {
    background: #e9ecef;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    color: #495057;
}

.mode-badge {
    background: #e9ecef;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    color: #495057;
}

.validation-info, .pending-info {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.validation-info p, .pending-info p {
    margin: 0.5rem 0;
}

.detail-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
    margin-top: 1rem;
}

.detail-actions .btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.detail-actions .btn-primary {
    background: #007bff;
    color: white;
}

.detail-actions .btn-secondary {
    background: #6c757d;
    color: white;
}

.detail-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 5% auto;
    }

    .modal-header {
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

    .detail-actions {
        flex-direction: column;
    }

    .detail-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.3rem;
    }

    .stripe-card-section {
        padding: 15px;
    }

    .stripe-info p {
        font-size: 0.8rem;
    }
}

/* Animation pour les éléments Stripe */
.stripe-card-element.StripeElement--focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.stripe-card-element.StripeElement--invalid {
    border-color: #dc3545;
}

.stripe-card-element.StripeElement--complete {
    border-color: #28a745;
}

/* Indicateur de chargement pour Stripe */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.fa-spinner.fa-spin {
    animation: fa-spin 2s infinite linear;
}

@keyframes fa-spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

@endsection
