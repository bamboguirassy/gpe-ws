const reclamation_bourseColumns = [
            { header: 'Date', field: 'date', dataKey: 'date' },
            { header: 'Objet', field: 'objet', dataKey: 'objet' },
            { header: 'Message', field: 'message', dataKey: 'message' },
        ];

const allowedReclamationBourseFieldsForFilter = [
    'date',
    'objet',
    'message',
];

export { reclamation_bourseColumns,allowedReclamationBourseFieldsForFilter };
