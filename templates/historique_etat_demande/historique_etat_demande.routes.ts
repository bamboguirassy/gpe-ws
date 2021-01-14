import { Route } from "@angular/router";
import { HistoriqueEtatDemandeListComponent } from './historique_etat_demande-list/historique_etat_demande-list.component';
import { HistoriqueEtatDemandeNewComponent } from './historique_etat_demande-new/historique_etat_demande-new.component';
import { HistoriqueEtatDemandeEditComponent } from './historique_etat_demande-edit/historique_etat_demande-edit.component';
import { HistoriqueEtatDemandeCloneComponent } from './historique_etat_demande-clone/historique_etat_demande-clone.component';
import { HistoriqueEtatDemandeShowComponent } from './historique_etat_demande-show/historique_etat_demande-show.component';
import { MultipleHistoriqueEtatDemandeResolver } from './multiple-historique_etat_demande.resolver';
import { OneHistoriqueEtatDemandeResolver } from './one-historique_etat_demande.resolver';

const historique_etat_demandeRoutes: Route = {
    path: 'historique_etat_demande', children: [
        { path: '', component: HistoriqueEtatDemandeListComponent, resolve: { historique_etat_demandes: MultipleHistoriqueEtatDemandeResolver } },
        { path: 'new', component: HistoriqueEtatDemandeNewComponent },
        { path: ':id/edit', component: HistoriqueEtatDemandeEditComponent, resolve: { historique_etat_demande: OneHistoriqueEtatDemandeResolver } },
        { path: ':id/clone', component: HistoriqueEtatDemandeCloneComponent, resolve: { historique_etat_demande: OneHistoriqueEtatDemandeResolver } },
        { path: ':id', component: HistoriqueEtatDemandeShowComponent, resolve: { historique_etat_demande: OneHistoriqueEtatDemandeResolver } }
    ]

};

export { historique_etat_demandeRoutes }
