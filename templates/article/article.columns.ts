const articleColumns = [
            { header: 'Titre', field: 'titre', dataKey: 'titre' },
            { header: 'Contenu', field: 'contenu', dataKey: 'contenu' },
            { header: 'DateCreation', field: 'dateCreation', dataKey: 'dateCreation' },
            { header: 'UserCreation', field: 'userCreation', dataKey: 'userCreation' },
            { header: 'Publie', field: 'publie', dataKey: 'publie' },
            { header: 'DatePublication', field: 'datePublication', dataKey: 'datePublication' },
            { header: 'UserPublication', field: 'userPublication', dataKey: 'userPublication' },
            { header: 'DateDesactivation', field: 'dateDesactivation', dataKey: 'dateDesactivation' },
            { header: 'UserDesactivation', field: 'userDesactivation', dataKey: 'userDesactivation' },
            { header: 'PhotoName', field: 'photoName', dataKey: 'photoName' },
            { header: 'PhotoPath', field: 'photoPath', dataKey: 'photoPath' },
        ];

const allowedArticleFieldsForFilter = [
    'titre',
    'contenu',
    'dateCreation',
    'userCreation',
    'publie',
    'datePublication',
    'userPublication',
    'dateDesactivation',
    'userDesactivation',
    'photoName',
    'photoPath',
];

export { articleColumns,allowedArticleFieldsForFilter };
