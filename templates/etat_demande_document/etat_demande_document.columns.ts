const etat_demande_documentColumns = [
            { header: 'Libelle', field: 'libelle', dataKey: 'libelle' },
            { header: 'Description', field: 'description', dataKey: 'description' },
            { header: 'CodeCouleur', field: 'codeCouleur', dataKey: 'codeCouleur' },
        ];

const allowedEtatDemandeDocumentFieldsForFilter = [
    'libelle',
    'description',
    'codeCouleur',
];

export { etat_demande_documentColumns,allowedEtatDemandeDocumentFieldsForFilter };
