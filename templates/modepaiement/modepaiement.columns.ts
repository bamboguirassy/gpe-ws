const modepaiementColumns = [
            { header: 'Codemodepaiement', field: 'codemodepaiement', dataKey: 'codemodepaiement' },
            { header: 'Libellemodepaiement', field: 'libellemodepaiement', dataKey: 'libellemodepaiement' },
            { header: 'Description', field: 'description', dataKey: 'description' },
        ];

const allowedModepaiementFieldsForFilter = [
    'codemodepaiement',
    'libellemodepaiement',
    'description',
];

export { modepaiementColumns,allowedModepaiementFieldsForFilter };
