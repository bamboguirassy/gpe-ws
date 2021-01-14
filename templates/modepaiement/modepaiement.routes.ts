import { Route } from "@angular/router";
import { ModepaiementListComponent } from './modepaiement-list/modepaiement-list.component';
import { ModepaiementNewComponent } from './modepaiement-new/modepaiement-new.component';
import { ModepaiementEditComponent } from './modepaiement-edit/modepaiement-edit.component';
import { ModepaiementCloneComponent } from './modepaiement-clone/modepaiement-clone.component';
import { ModepaiementShowComponent } from './modepaiement-show/modepaiement-show.component';
import { MultipleModepaiementResolver } from './multiple-modepaiement.resolver';
import { OneModepaiementResolver } from './one-modepaiement.resolver';

const modepaiementRoutes: Route = {
    path: 'modepaiement', children: [
        { path: '', component: ModepaiementListComponent, resolve: { modepaiements: MultipleModepaiementResolver } },
        { path: 'new', component: ModepaiementNewComponent },
        { path: ':id/edit', component: ModepaiementEditComponent, resolve: { modepaiement: OneModepaiementResolver } },
        { path: ':id/clone', component: ModepaiementCloneComponent, resolve: { modepaiement: OneModepaiementResolver } },
        { path: ':id', component: ModepaiementShowComponent, resolve: { modepaiement: OneModepaiementResolver } }
    ]

};

export { modepaiementRoutes }
