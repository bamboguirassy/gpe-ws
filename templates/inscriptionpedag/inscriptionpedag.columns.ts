const inscriptionpedagColumns = [
            { header: 'Dateinscriptionpedag', field: 'dateinscriptionpedag', dataKey: 'dateinscriptionpedag' },
            { header: 'Passage', field: 'passage', dataKey: 'passage' },
            { header: 'Valide', field: 'valide', dataKey: 'valide' },
            { header: 'Moyenneobtenue', field: 'moyenneobtenue', dataKey: 'moyenneobtenue' },
        ];

const allowedInscriptionpedagFieldsForFilter = [
    'dateinscriptionpedag',
    'passage',
    'valide',
    'moyenneobtenue',
];

export { inscriptionpedagColumns,allowedInscriptionpedagFieldsForFilter };
