import { Route } from "@angular/router";
import { FiliereListComponent } from './filiere-list/filiere-list.component';
import { FiliereNewComponent } from './filiere-new/filiere-new.component';
import { FiliereEditComponent } from './filiere-edit/filiere-edit.component';
import { FiliereCloneComponent } from './filiere-clone/filiere-clone.component';
import { FiliereShowComponent } from './filiere-show/filiere-show.component';
import { MultipleFiliereResolver } from './multiple-filiere.resolver';
import { OneFiliereResolver } from './one-filiere.resolver';

const filiereRoutes: Route = {
    path: 'filiere', children: [
        { path: '', component: FiliereListComponent, resolve: { filieres: MultipleFiliereResolver } },
        { path: 'new', component: FiliereNewComponent },
        { path: ':id/edit', component: FiliereEditComponent, resolve: { filiere: OneFiliereResolver } },
        { path: ':id/clone', component: FiliereCloneComponent, resolve: { filiere: OneFiliereResolver } },
        { path: ':id', component: FiliereShowComponent, resolve: { filiere: OneFiliereResolver } }
    ]

};

export { filiereRoutes }
