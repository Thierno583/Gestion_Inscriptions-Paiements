<?php

namespace App\Exports;

use App\Models\Inscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InscriptionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inscription::with(['etudiant.personne', 'classe'])
            ->latest()
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Matricule',
            'Nom',
            'Prénom',
            'Classe',
            'Année Académique',
            'Date Inscription',
            'Statut',
            'Montant Total',
            'Montant Payé',
            'Reste à Payer'
        ];
    }

    /**
     * @param mixed $inscription
     *
     * @return array
     */
    public function map($inscription): array
    {
        return [
            $inscription->id,
            $inscription->etudiant->matricule ?? 'N/A',
            $inscription->etudiant->personne->nom ?? 'N/A',
            $inscription->etudiant->personne->prenom ?? 'N/A',
            $inscription->classe->libelle ?? 'N/A',
            $inscription->annee_academique,
            $inscription->date_inscription->format('d/m/Y'),
            $this->getStatusLabel($inscription->statut),
            number_format($inscription->montant_total, 0, ',', ' '),
            number_format($inscription->montant_paye, 0, ',', ' '),
            number_format(($inscription->montant_total - $inscription->montant_paye), 0, ',', ' '),
        ];
    }

    /**
     * Get status label
     *
     * @param string $status
     * @return string
     */
    private function getStatusLabel($status)
    {
        $statuses = [
            'en_attente' => 'En attente',
            'validee' => 'Validée',
            'rejetee' => 'Rejetée',
            'annulee' => 'Annulée'
        ];

        return $statuses[$status] ?? $status;
    }
}
