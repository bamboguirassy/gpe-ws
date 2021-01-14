const bourse_etudiantColumns = [
            { header: 'Prenoms', field: 'prenoms', dataKey: 'prenoms' },
            { header: 'Nom', field: 'nom', dataKey: 'nom' },
            { header: 'DateNaissance', field: 'dateNaissance', dataKey: 'dateNaissance' },
            { header: 'LieuNaissance', field: 'lieuNaissance', dataKey: 'lieuNaissance' },
            { header: 'TauxBourse', field: 'tauxBourse', dataKey: 'tauxBourse' },
            { header: 'MontantBourse', field: 'montantBourse', dataKey: 'montantBourse' },
            { header: 'Mois', field: 'mois', dataKey: 'mois' },
            { header: 'Annee', field: 'annee', dataKey: 'annee' },
        ];

const allowedBourseEtudiantFieldsForFilter = [
    'prenoms',
    'nom',
    'dateNaissance',
    'lieuNaissance',
    'tauxBourse',
    'montantBourse',
    'mois',
    'annee',
];

export { bourse_etudiantColumns,allowedBourseEtudiantFieldsForFilter };
