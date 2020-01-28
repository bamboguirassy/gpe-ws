import { Route } from "@angular/router";
import { RegimeinscriptionListComponent } from './regimeinscription-list/regimeinscription-list.component';
import { RegimeinscriptionNewComponent } from './regimeinscription-new/regimeinscription-new.component';
import { RegimeinscriptionEditComponent } from './regimeinscription-edit/regimeinscription-edit.component';
import { RegimeinscriptionCloneComponent } from './regimeinscription-clone/regimeinscription-clone.component';
import { RegimeinscriptionShowComponent } from './regimeinscription-show/regimeinscription-show.component';
import { MultipleRegimeinscriptionResolver } from './multiple-regimeinscription.resolver';
import { OneRegimeinscriptionResolver } from './one-regimeinscription.resolver';

const regimeinscriptionRoutes: Route = {
    path: 'regimeinscription', children: [
        { path: '', component: RegimeinscriptionListComponent, resolve: { regimeinscriptions: MultipleRegimeinscriptionResolver } },
        { path: 'new', component: RegimeinscriptionNewComponent },
        { path: ':id/edit', component: RegimeinscriptionEditComponent, resolve: { regimeinscription: OneRegimeinscriptionResolver } },
        { path: ':id/clone', component: RegimeinscriptionCloneComponent, resolve: { regimeinscription: OneRegimeinscriptionResolver } },
        { path: ':id', component: RegimeinscriptionShowComponent, resolve: { regimeinscription: OneRegimeinscriptionResolver } }
    ]

};

export { regimeinscriptionRoutes }
