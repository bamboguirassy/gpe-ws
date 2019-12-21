import { Route } from "@angular/router";
import { InscriptionacadListComponent } from './inscriptionacad-list/inscriptionacad-list.component';
import { InscriptionacadNewComponent } from './inscriptionacad-new/inscriptionacad-new.component';
import { InscriptionacadEditComponent } from './inscriptionacad-edit/inscriptionacad-edit.component';
import { InscriptionacadCloneComponent } from './inscriptionacad-clone/inscriptionacad-clone.component';
import { InscriptionacadShowComponent } from './inscriptionacad-show/inscriptionacad-show.component';
import { MultipleInscriptionacadResolver } from './multiple-inscriptionacad.resolver';
import { OneInscriptionacadResolver } from './one-inscriptionacad.resolver';

const inscriptionacadRoutes: Route = {
    path: 'inscriptionacad', children: [
        { path: '', component: InscriptionacadListComponent, resolve: { inscriptionacads: MultipleInscriptionacadResolver } },
        { path: 'new', component: InscriptionacadNewComponent },
        { path: ':id/edit', component: InscriptionacadEditComponent, resolve: { inscriptionacad: OneInscriptionacadResolver } },
        { path: ':id/clone', component: InscriptionacadCloneComponent, resolve: { inscriptionacad: OneInscriptionacadResolver } },
        { path: ':id', component: InscriptionacadShowComponent, resolve: { inscriptionacad: OneInscriptionacadResolver } }
    ]

};

export { inscriptionacadRoutes }
