const inscriptionTemporaireColumns = [
            { header: 'Idclasse', field: 'idclasse', dataKey: 'idclasse' },
            { header: 'Idspecialite', field: 'idspecialite', dataKey: 'idspecialite' },
            { header: 'Idregimeinscription', field: 'idregimeinscription', dataKey: 'idregimeinscription' },
            { header: 'Idmodaliteenseignement', field: 'idmodaliteenseignement', dataKey: 'idmodaliteenseignement' },
            { header: 'Idetudiant', field: 'idetudiant', dataKey: 'idetudiant' },
            { header: 'Idbourse', field: 'idbourse', dataKey: 'idbourse' },
            { header: 'Passage', field: 'passage', dataKey: 'passage' },
            { header: 'Idmodepaiement', field: 'idmodepaiement', dataKey: 'idmodepaiement' },
            { header: 'Montantinscriptionacad', field: 'montantinscriptionacad', dataKey: 'montantinscriptionacad' },
            { header: 'Coutformation', field: 'coutformation', dataKey: 'coutformation' },
            { header: 'Numquittance', field: 'numquittance', dataKey: 'numquittance' },
            { header: 'Source', field: 'source', dataKey: 'source' },
            { header: 'Croust', field: 'croust', dataKey: 'croust' },
        ];

const allowedInscriptionTemporaireFieldsForFilter = [
    'idclasse',
    'idspecialite',
    'idregimeinscription',
    'idmodaliteenseignement',
    'idetudiant',
    'idbourse',
    'passage',
    'idmodepaiement',
    'montantinscriptionacad',
    'coutformation',
    'numquittance',
    'source',
    'croust',
];

export { inscriptionTemporaireColumns,allowedInscriptionTemporaireFieldsForFilter };
