const classeColumns = [
            { header: 'Codeclasse', field: 'codeclasse', dataKey: 'codeclasse' },
            { header: 'Libelleclasse', field: 'libelleclasse', dataKey: 'libelleclasse' },
            { header: 'Etat', field: 'etat', dataKey: 'etat' },
        ];

const allowedClasseFieldsForFilter = [
    'codeclasse',
    'libelleclasse',
    'etat',
];

export { classeColumns,allowedClasseFieldsForFilter };
