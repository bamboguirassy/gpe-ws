const etat_reclamation_bourseColumns = [
            { header: 'Libelle', field: 'libelle', dataKey: 'libelle' },
            { header: 'CodeCouleur', field: 'codeCouleur', dataKey: 'codeCouleur' },
            { header: 'Description', field: 'description', dataKey: 'description' },
        ];

const allowedEtatReclamationBourseFieldsForFilter = [
    'libelle',
    'codeCouleur',
    'description',
];

export { etat_reclamation_bourseColumns,allowedEtatReclamationBourseFieldsForFilter };
