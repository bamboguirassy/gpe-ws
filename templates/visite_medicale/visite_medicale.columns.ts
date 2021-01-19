const visiteMedicaleColumns = [
            { header: 'Date', field: 'date', dataKey: 'date' },
            { header: 'Apte', field: 'apte', dataKey: 'apte' },
            { header: 'Commentaire', field: 'commentaire', dataKey: 'commentaire' },
        ];

const allowedVisiteMedicaleFieldsForFilter = [
    'date',
    'apte',
    'commentaire',
];

export { visiteMedicaleColumns,allowedVisiteMedicaleFieldsForFilter };
