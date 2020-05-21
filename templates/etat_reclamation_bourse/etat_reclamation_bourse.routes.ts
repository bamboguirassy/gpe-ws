import { Route } from "@angular/router";
import { EtatReclamationBourseListComponent } from './etat_reclamation_bourse-list/etat_reclamation_bourse-list.component';
import { EtatReclamationBourseNewComponent } from './etat_reclamation_bourse-new/etat_reclamation_bourse-new.component';
import { EtatReclamationBourseEditComponent } from './etat_reclamation_bourse-edit/etat_reclamation_bourse-edit.component';
import { EtatReclamationBourseCloneComponent } from './etat_reclamation_bourse-clone/etat_reclamation_bourse-clone.component';
import { EtatReclamationBourseShowComponent } from './etat_reclamation_bourse-show/etat_reclamation_bourse-show.component';
import { MultipleEtatReclamationBourseResolver } from './multiple-etat_reclamation_bourse.resolver';
import { OneEtatReclamationBourseResolver } from './one-etat_reclamation_bourse.resolver';

const etat_reclamation_bourseRoutes: Route = {
    path: 'etat_reclamation_bourse', children: [
        { path: '', component: EtatReclamationBourseListComponent, resolve: { etat_reclamation_bourses: MultipleEtatReclamationBourseResolver } },
        { path: 'new', component: EtatReclamationBourseNewComponent },
        { path: ':id/edit', component: EtatReclamationBourseEditComponent, resolve: { etat_reclamation_bourse: OneEtatReclamationBourseResolver } },
        { path: ':id/clone', component: EtatReclamationBourseCloneComponent, resolve: { etat_reclamation_bourse: OneEtatReclamationBourseResolver } },
        { path: ':id', component: EtatReclamationBourseShowComponent, resolve: { etat_reclamation_bourse: OneEtatReclamationBourseResolver } }
    ]

};

export { etat_reclamation_bourseRoutes }
