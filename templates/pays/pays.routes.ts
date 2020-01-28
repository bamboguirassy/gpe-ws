import { Route } from "@angular/router";
import { PaysListComponent } from './pays-list/pays-list.component';
import { PaysNewComponent } from './pays-new/pays-new.component';
import { PaysEditComponent } from './pays-edit/pays-edit.component';
import { PaysCloneComponent } from './pays-clone/pays-clone.component';
import { PaysShowComponent } from './pays-show/pays-show.component';
import { MultiplePaysResolver } from './multiple-pays.resolver';
import { OnePaysResolver } from './one-pays.resolver';

const payRoutes: Route = {
    path: 'pays', children: [
        { path: '', component: PaysListComponent, resolve: { pays: MultiplePaysResolver } },
        { path: 'new', component: PaysNewComponent },
        { path: ':id/edit', component: PaysEditComponent, resolve: { pay: OnePaysResolver } },
        { path: ':id/clone', component: PaysCloneComponent, resolve: { pay: OnePaysResolver } },
        { path: ':id', component: PaysShowComponent, resolve: { pay: OnePaysResolver } }
    ]

};

export { payRoutes }
