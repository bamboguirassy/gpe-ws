const regimeinscriptionColumns = [
            { header: 'Coderegimeinscription', field: 'coderegimeinscription', dataKey: 'coderegimeinscription' },
            { header: 'Libelleregimeinscription', field: 'libelleregimeinscription', dataKey: 'libelleregimeinscription' },
            { header: 'Description', field: 'description', dataKey: 'description' },
        ];

const allowedRegimeinscriptionFieldsForFilter = [
    'coderegimeinscription',
    'libelleregimeinscription',
    'description',
];

export { regimeinscriptionColumns,allowedRegimeinscriptionFieldsForFilter };
