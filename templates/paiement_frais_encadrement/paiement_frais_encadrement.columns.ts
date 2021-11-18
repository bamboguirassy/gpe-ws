const paiementFraisEncadrementColumns = [
            { header: 'DatePaiement', field: 'datePaiement', dataKey: 'datePaiement' },
            { header: 'MontantPaye', field: 'montantPaye', dataKey: 'montantPaye' },
            { header: 'MethodePaiement', field: 'methodePaiement', dataKey: 'methodePaiement' },
        ];

const allowedPaiementFraisEncadrementFieldsForFilter = [
    'datePaiement',
    'montantPaye',
    'methodePaiement',
];

export { paiementFraisEncadrementColumns,allowedPaiementFraisEncadrementFieldsForFilter };
