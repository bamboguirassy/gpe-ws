import { Route } from "@angular/router";
import { InscriptionTemporaireListComponent } from './inscriptiontemporaire-list/inscriptiontemporaire-list.component';
import { InscriptionTemporaireNewComponent } from './inscriptiontemporaire-new/inscriptiontemporaire-new.component';
import { InscriptionTemporaireEditComponent } from './inscriptiontemporaire-edit/inscriptiontemporaire-edit.component';
import { InscriptionTemporaireCloneComponent } from './inscriptiontemporaire-clone/inscriptiontemporaire-clone.component';
import { InscriptionTemporaireShowComponent } from './inscriptiontemporaire-show/inscriptiontemporaire-show.component';
import { MultipleInscriptionTemporaireResolver } from './multiple-inscriptiontemporaire.resolver';
import { OneInscriptionTemporaireResolver } from './one-inscriptiontemporaire.resolver';

const inscriptionTemporaireRoutes: Route = {
    path: 'inscriptiontemporaire', children: [
        { path: '', component: InscriptionTemporaireListComponent, resolve: { inscriptionTemporaires: MultipleInscriptionTemporaireResolver } },
        { path: 'new', component: InscriptionTemporaireNewComponent },
        { path: ':id/edit', component: InscriptionTemporaireEditComponent, resolve: { inscriptionTemporaire: OneInscriptionTemporaireResolver } },
        { path: ':id/clone', component: InscriptionTemporaireCloneComponent, resolve: { inscriptionTemporaire: OneInscriptionTemporaireResolver } },
        { path: ':id', component: InscriptionTemporaireShowComponent, resolve: { inscriptionTemporaire: OneInscriptionTemporaireResolver } }
    ]

};

export { inscriptionTemporaireRoutes }
