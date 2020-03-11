import { Route } from "@angular/router";
import { AnneeacadListComponent } from './anneeacad-list/anneeacad-list.component';
import { AnneeacadNewComponent } from './anneeacad-new/anneeacad-new.component';
import { AnneeacadEditComponent } from './anneeacad-edit/anneeacad-edit.component';
import { AnneeacadCloneComponent } from './anneeacad-clone/anneeacad-clone.component';
import { AnneeacadShowComponent } from './anneeacad-show/anneeacad-show.component';
import { MultipleAnneeacadResolver } from './multiple-anneeacad.resolver';
import { OneAnneeacadResolver } from './one-anneeacad.resolver';

const anneeacadRoutes: Route = {
    path: 'anneeacad', children: [
        { path: '', component: AnneeacadListComponent, resolve: { anneeacads: MultipleAnneeacadResolver } },
        { path: 'new', component: AnneeacadNewComponent },
        { path: ':id/edit', component: AnneeacadEditComponent, resolve: { anneeacad: OneAnneeacadResolver } },
        { path: ':id/clone', component: AnneeacadCloneComponent, resolve: { anneeacad: OneAnneeacadResolver } },
        { path: ':id', component: AnneeacadShowComponent, resolve: { anneeacad: OneAnneeacadResolver } }
    ]

};

export { anneeacadRoutes }
