import { Route } from "@angular/router";
import { SpecialiteListComponent } from './specialite-list/specialite-list.component';
import { SpecialiteNewComponent } from './specialite-new/specialite-new.component';
import { SpecialiteEditComponent } from './specialite-edit/specialite-edit.component';
import { SpecialiteCloneComponent } from './specialite-clone/specialite-clone.component';
import { SpecialiteShowComponent } from './specialite-show/specialite-show.component';
import { MultipleSpecialiteResolver } from './multiple-specialite.resolver';
import { OneSpecialiteResolver } from './one-specialite.resolver';

const specialiteRoutes: Route = {
    path: 'specialite', children: [
        { path: '', component: SpecialiteListComponent, resolve: { specialites: MultipleSpecialiteResolver } },
        { path: 'new', component: SpecialiteNewComponent },
        { path: ':id/edit', component: SpecialiteEditComponent, resolve: { specialite: OneSpecialiteResolver } },
        { path: ':id/clone', component: SpecialiteCloneComponent, resolve: { specialite: OneSpecialiteResolver } },
        { path: ':id', component: SpecialiteShowComponent, resolve: { specialite: OneSpecialiteResolver } }
    ]

};

export { specialiteRoutes }
