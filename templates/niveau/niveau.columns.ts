const niveauColumns = [
            { header: 'Codeniveau', field: 'codeniveau', dataKey: 'codeniveau' },
            { header: 'CodeSigesr', field: 'codeSigesr', dataKey: 'codeSigesr' },
            { header: 'Libelleniveau', field: 'libelleniveau', dataKey: 'libelleniveau' },
            { header: 'Ddc', field: 'ddc', dataKey: 'ddc' },
            { header: 'Description', field: 'description', dataKey: 'description' },
        ];

const allowedNiveauFieldsForFilter = [
    'codeniveau',
    'codeSigesr',
    'libelleniveau',
    'ddc',
    'description',
];

export { niveauColumns,allowedNiveauFieldsForFilter };
