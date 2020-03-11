import { Route } from "@angular/router";
import { FiliereniveauListComponent } from './filiereniveau-list/filiereniveau-list.component';
import { FiliereniveauNewComponent } from './filiereniveau-new/filiereniveau-new.component';
import { FiliereniveauEditComponent } from './filiereniveau-edit/filiereniveau-edit.component';
import { FiliereniveauCloneComponent } from './filiereniveau-clone/filiereniveau-clone.component';
import { FiliereniveauShowComponent } from './filiereniveau-show/filiereniveau-show.component';
import { MultipleFiliereniveauResolver } from './multiple-filiereniveau.resolver';
import { OneFiliereniveauResolver } from './one-filiereniveau.resolver';

const filiereniveauRoutes: Route = {
    path: 'filiereniveau', children: [
        { path: '', component: FiliereniveauListComponent, resolve: { filiereniveaus: MultipleFiliereniveauResolver } },
        { path: 'new', component: FiliereniveauNewComponent },
        { path: ':id/edit', component: FiliereniveauEditComponent, resolve: { filiereniveau: OneFiliereniveauResolver } },
        { path: ':id/clone', component: FiliereniveauCloneComponent, resolve: { filiereniveau: OneFiliereniveauResolver } },
        { path: ':id', component: FiliereniveauShowComponent, resolve: { filiereniveau: OneFiliereniveauResolver } }
    ]

};

export { filiereniveauRoutes }
