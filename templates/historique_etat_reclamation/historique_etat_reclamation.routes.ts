import { Route } from "@angular/router";
import { HistoriqueEtatReclamationListComponent } from './historique_etat_reclamation-list/historique_etat_reclamation-list.component';
import { HistoriqueEtatReclamationNewComponent } from './historique_etat_reclamation-new/historique_etat_reclamation-new.component';
import { HistoriqueEtatReclamationEditComponent } from './historique_etat_reclamation-edit/historique_etat_reclamation-edit.component';
import { HistoriqueEtatReclamationCloneComponent } from './historique_etat_reclamation-clone/historique_etat_reclamation-clone.component';
import { HistoriqueEtatReclamationShowComponent } from './historique_etat_reclamation-show/historique_etat_reclamation-show.component';
import { MultipleHistoriqueEtatReclamationResolver } from './multiple-historique_etat_reclamation.resolver';
import { OneHistoriqueEtatReclamationResolver } from './one-historique_etat_reclamation.resolver';

const historique_etat_reclamationRoutes: Route = {
    path: 'historique_etat_reclamation', children: [
        { path: '', component: HistoriqueEtatReclamationListComponent, resolve: { historique_etat_reclamations: MultipleHistoriqueEtatReclamationResolver } },
        { path: 'new', component: HistoriqueEtatReclamationNewComponent },
        { path: ':id/edit', component: HistoriqueEtatReclamationEditComponent, resolve: { historique_etat_reclamation: OneHistoriqueEtatReclamationResolver } },
        { path: ':id/clone', component: HistoriqueEtatReclamationCloneComponent, resolve: { historique_etat_reclamation: OneHistoriqueEtatReclamationResolver } },
        { path: ':id', component: HistoriqueEtatReclamationShowComponent, resolve: { historique_etat_reclamation: OneHistoriqueEtatReclamationResolver } }
    ]

};

export { historique_etat_reclamationRoutes }
