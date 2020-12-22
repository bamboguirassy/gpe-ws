const assistanceEmailColumns = [
            { header: 'TypeAssistance', field: 'typeAssistance', dataKey: 'typeAssistance' },
            { header: 'Email', field: 'email', dataKey: 'email' },
            { header: 'Etat', field: 'etat', dataKey: 'etat' },
            { header: 'DestinationApp', field: 'destinationApp', dataKey: 'destinationApp' },
        ];

const allowedAssistanceEmailFieldsForFilter = [
    'typeAssistance',
    'email',
    'etat',
    'destinationApp',
];

export { assistanceEmailColumns,allowedAssistanceEmailFieldsForFilter };
