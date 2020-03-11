const filiereColumns = [
            { header: 'Codefiliere', field: 'codefiliere', dataKey: 'codefiliere' },
            { header: 'Libellefiliere', field: 'libellefiliere', dataKey: 'libellefiliere' },
            { header: 'Codenum', field: 'codenum', dataKey: 'codenum' },
            { header: 'Description', field: 'description', dataKey: 'description' },
            { header: 'CodeSigesr', field: 'codeSigesr', dataKey: 'codeSigesr' },
        ];

const allowedFiliereFieldsForFilter = [
    'codefiliere',
    'libellefiliere',
    'codenum',
    'description',
    'codeSigesr',
];

export { filiereColumns,allowedFiliereFieldsForFilter };
