import { Route } from "@angular/router";
import { PaiementFraisEncadrementListComponent } from './paiementfraisencadrement-list/paiementfraisencadrement-list.component';
import { PaiementFraisEncadrementNewComponent } from './paiementfraisencadrement-new/paiementfraisencadrement-new.component';
import { PaiementFraisEncadrementEditComponent } from './paiementfraisencadrement-edit/paiementfraisencadrement-edit.component';
import { PaiementFraisEncadrementCloneComponent } from './paiementfraisencadrement-clone/paiementfraisencadrement-clone.component';
import { PaiementFraisEncadrementShowComponent } from './paiementfraisencadrement-show/paiementfraisencadrement-show.component';
import { MultiplePaiementFraisEncadrementResolver } from './multiple-paiementfraisencadrement.resolver';
import { OnePaiementFraisEncadrementResolver } from './one-paiementfraisencadrement.resolver';

const paiementFraisEncadrementRoutes: Route = {
    path: 'paiementfraisencadrement', children: [
        { path: '', component: PaiementFraisEncadrementListComponent, resolve: { paiementFraisEncadrements: MultiplePaiementFraisEncadrementResolver } },
        { path: 'new', component: PaiementFraisEncadrementNewComponent },
        { path: ':id/edit', component: PaiementFraisEncadrementEditComponent, resolve: { paiementFraisEncadrement: OnePaiementFraisEncadrementResolver } },
        { path: ':id/clone', component: PaiementFraisEncadrementCloneComponent, resolve: { paiementFraisEncadrement: OnePaiementFraisEncadrementResolver } },
        { path: ':id', component: PaiementFraisEncadrementShowComponent, resolve: { paiementFraisEncadrement: OnePaiementFraisEncadrementResolver } }
    ]

};

export { paiementFraisEncadrementRoutes }
