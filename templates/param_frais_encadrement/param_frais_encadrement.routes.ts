import { Route } from "@angular/router";
import { ParamFraisEncadrementListComponent } from './paramfraisencadrement-list/paramfraisencadrement-list.component';
import { ParamFraisEncadrementNewComponent } from './paramfraisencadrement-new/paramfraisencadrement-new.component';
import { ParamFraisEncadrementEditComponent } from './paramfraisencadrement-edit/paramfraisencadrement-edit.component';
import { ParamFraisEncadrementCloneComponent } from './paramfraisencadrement-clone/paramfraisencadrement-clone.component';
import { ParamFraisEncadrementShowComponent } from './paramfraisencadrement-show/paramfraisencadrement-show.component';
import { MultipleParamFraisEncadrementResolver } from './multiple-paramfraisencadrement.resolver';
import { OneParamFraisEncadrementResolver } from './one-paramfraisencadrement.resolver';

const paramFraisEncadrementRoutes: Route = {
    path: 'paramfraisencadrement', children: [
        { path: '', component: ParamFraisEncadrementListComponent, resolve: { paramFraisEncadrements: MultipleParamFraisEncadrementResolver } },
        { path: 'new', component: ParamFraisEncadrementNewComponent },
        { path: ':id/edit', component: ParamFraisEncadrementEditComponent, resolve: { paramFraisEncadrement: OneParamFraisEncadrementResolver } },
        { path: ':id/clone', component: ParamFraisEncadrementCloneComponent, resolve: { paramFraisEncadrement: OneParamFraisEncadrementResolver } },
        { path: ':id', component: ParamFraisEncadrementShowComponent, resolve: { paramFraisEncadrement: OneParamFraisEncadrementResolver } }
    ]

};

export { paramFraisEncadrementRoutes }
