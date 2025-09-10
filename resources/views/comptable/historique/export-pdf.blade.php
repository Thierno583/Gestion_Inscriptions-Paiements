<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historique des paiements</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h3>Historique des paiements</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Classe</th>
                <th>Montant</th>
                <th>Mode</th>
                <th>Statut</th>
                <th>Référence</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $paiement)
            <tr>
                <td>{{ $paiement->id }}</td>
                <td>{{ $paiement->inscription->etudiant->personne->nom ?? 'N/A' }}</td>
                <td>{{ $paiement->inscription->etudiant->personne->prenom ?? 'N/A' }}</td>
                <td>{{ $paiement->inscription->classe->libelle ?? 'N/A' }}</td>
                <td>{{ $paiement->montant }}</td>
                <td>{{ $paiement->mode_paiement }}</td>
                <td>{{ $paiement->statut }}</td>
                <td>{{ $paiement->reference_transaction }}</td>
                <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
