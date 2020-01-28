const specialiteColumns = [
            { header: 'Codespecialite', field: 'codespecialite', dataKey: 'codespecialite' },
            { header: 'Libellespecialite', field: 'libellespecialite', dataKey: 'libellespecialite' },
            { header: 'Description', field: 'description', dataKey: 'description' },
            { header: 'Langueutilisee', field: 'langueutilisee', dataKey: 'langueutilisee' },
            { header: 'Typeaccreditation', field: 'typeaccreditation', dataKey: 'typeaccreditation' },
            { header: 'CodeSigesrSpecialite', field: 'codeSigesrSpecialite', dataKey: 'codeSigesrSpecialite' },
        ];

const allowedSpecialiteFieldsForFilter = [
    'codespecialite',
    'libellespecialite',
    'description',
    'langueutilisee',
    'typeaccreditation',
    'codeSigesrSpecialite',
];

export { specialiteColumns,allowedSpecialiteFieldsForFilter };
