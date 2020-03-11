const anneeacadColumns = [
            { header: 'Codeanneeacad', field: 'codeanneeacad', dataKey: 'codeanneeacad' },
            { header: 'Libelleanneeacad', field: 'libelleanneeacad', dataKey: 'libelleanneeacad' },
            { header: 'Encours', field: 'encours', dataKey: 'encours' },
            { header: 'Dateouvert', field: 'dateouvert', dataKey: 'dateouvert' },
            { header: 'Dateferm', field: 'dateferm', dataKey: 'dateferm' },
            { header: 'NbreInscrits', field: 'nbreInscrits', dataKey: 'nbreInscrits' },
        ];

const allowedAnneeacadFieldsForFilter = [
    'codeanneeacad',
    'libelleanneeacad',
    'encours',
    'dateouvert',
    'dateferm',
    'nbreInscrits',
];

export { anneeacadColumns,allowedAnneeacadFieldsForFilter };
