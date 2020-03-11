import { Route } from "@angular/router";
import { NiveauListComponent } from './niveau-list/niveau-list.component';
import { NiveauNewComponent } from './niveau-new/niveau-new.component';
import { NiveauEditComponent } from './niveau-edit/niveau-edit.component';
import { NiveauCloneComponent } from './niveau-clone/niveau-clone.component';
import { NiveauShowComponent } from './niveau-show/niveau-show.component';
import { MultipleNiveauResolver } from './multiple-niveau.resolver';
import { OneNiveauResolver } from './one-niveau.resolver';

const niveauRoutes: Route = {
    path: 'niveau', children: [
        { path: '', component: NiveauListComponent, resolve: { niveaus: MultipleNiveauResolver } },
        { path: 'new', component: NiveauNewComponent },
        { path: ':id/edit', component: NiveauEditComponent, resolve: { niveau: OneNiveauResolver } },
        { path: ':id/clone', component: NiveauCloneComponent, resolve: { niveau: OneNiveauResolver } },
        { path: ':id', component: NiveauShowComponent, resolve: { niveau: OneNiveauResolver } }
    ]

};

export { niveauRoutes }
