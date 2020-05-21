import { Route } from "@angular/router";
import { ReclamationBourseListComponent } from './reclamation_bourse-list/reclamation_bourse-list.component';
import { ReclamationBourseNewComponent } from './reclamation_bourse-new/reclamation_bourse-new.component';
import { ReclamationBourseEditComponent } from './reclamation_bourse-edit/reclamation_bourse-edit.component';
import { ReclamationBourseCloneComponent } from './reclamation_bourse-clone/reclamation_bourse-clone.component';
import { ReclamationBourseShowComponent } from './reclamation_bourse-show/reclamation_bourse-show.component';
import { MultipleReclamationBourseResolver } from './multiple-reclamation_bourse.resolver';
import { OneReclamationBourseResolver } from './one-reclamation_bourse.resolver';

const reclamation_bourseRoutes: Route = {
    path: 'reclamation_bourse', children: [
        { path: '', component: ReclamationBourseListComponent, resolve: { reclamation_bourses: MultipleReclamationBourseResolver } },
        { path: 'new', component: ReclamationBourseNewComponent },
        { path: ':id/edit', component: ReclamationBourseEditComponent, resolve: { reclamation_bourse: OneReclamationBourseResolver } },
        { path: ':id/clone', component: ReclamationBourseCloneComponent, resolve: { reclamation_bourse: OneReclamationBourseResolver } },
        { path: ':id', component: ReclamationBourseShowComponent, resolve: { reclamation_bourse: OneReclamationBourseResolver } }
    ]

};

export { reclamation_bourseRoutes }
