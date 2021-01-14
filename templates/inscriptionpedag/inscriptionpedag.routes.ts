import { Route } from "@angular/router";
import { InscriptionpedagListComponent } from './inscriptionpedag-list/inscriptionpedag-list.component';
import { InscriptionpedagNewComponent } from './inscriptionpedag-new/inscriptionpedag-new.component';
import { InscriptionpedagEditComponent } from './inscriptionpedag-edit/inscriptionpedag-edit.component';
import { InscriptionpedagCloneComponent } from './inscriptionpedag-clone/inscriptionpedag-clone.component';
import { InscriptionpedagShowComponent } from './inscriptionpedag-show/inscriptionpedag-show.component';
import { MultipleInscriptionpedagResolver } from './multiple-inscriptionpedag.resolver';
import { OneInscriptionpedagResolver } from './one-inscriptionpedag.resolver';

const inscriptionpedagRoutes: Route = {
    path: 'inscriptionpedag', children: [
        { path: '', component: InscriptionpedagListComponent, resolve: { inscriptionpedags: MultipleInscriptionpedagResolver } },
        { path: 'new', component: InscriptionpedagNewComponent },
        { path: ':id/edit', component: InscriptionpedagEditComponent, resolve: { inscriptionpedag: OneInscriptionpedagResolver } },
        { path: ':id/clone', component: InscriptionpedagCloneComponent, resolve: { inscriptionpedag: OneInscriptionpedagResolver } },
        { path: ':id', component: InscriptionpedagShowComponent, resolve: { inscriptionpedag: OneInscriptionpedagResolver } }
    ]

};

export { inscriptionpedagRoutes }
