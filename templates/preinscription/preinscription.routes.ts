import { Route } from "@angular/router";
import { PreinscriptionListComponent } from './preinscription-list/preinscription-list.component';
import { PreinscriptionNewComponent } from './preinscription-new/preinscription-new.component';
import { PreinscriptionEditComponent } from './preinscription-edit/preinscription-edit.component';
import { PreinscriptionCloneComponent } from './preinscription-clone/preinscription-clone.component';
import { PreinscriptionShowComponent } from './preinscription-show/preinscription-show.component';
import { MultiplePreinscriptionResolver } from './multiple-preinscription.resolver';
import { OnePreinscriptionResolver } from './one-preinscription.resolver';

const preinscriptionRoutes: Route = {
    path: 'preinscription', children: [
        { path: '', component: PreinscriptionListComponent, resolve: { preinscriptions: MultiplePreinscriptionResolver } },
        { path: 'new', component: PreinscriptionNewComponent },
        { path: ':id/edit', component: PreinscriptionEditComponent, resolve: { preinscription: OnePreinscriptionResolver } },
        { path: ':id/clone', component: PreinscriptionCloneComponent, resolve: { preinscription: OnePreinscriptionResolver } },
        { path: ':id', component: PreinscriptionShowComponent, resolve: { preinscription: OnePreinscriptionResolver } }
    ]

};

export { preinscriptionRoutes }
