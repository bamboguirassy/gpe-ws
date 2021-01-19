import { Route } from "@angular/router";
import { VisiteMedicaleListComponent } from './visitemedicale-list/visitemedicale-list.component';
import { VisiteMedicaleNewComponent } from './visitemedicale-new/visitemedicale-new.component';
import { VisiteMedicaleEditComponent } from './visitemedicale-edit/visitemedicale-edit.component';
import { VisiteMedicaleCloneComponent } from './visitemedicale-clone/visitemedicale-clone.component';
import { VisiteMedicaleShowComponent } from './visitemedicale-show/visitemedicale-show.component';
import { MultipleVisiteMedicaleResolver } from './multiple-visitemedicale.resolver';
import { OneVisiteMedicaleResolver } from './one-visitemedicale.resolver';

const visiteMedicaleRoutes: Route = {
    path: 'visitemedicale', children: [
        { path: '', component: VisiteMedicaleListComponent, resolve: { visiteMedicales: MultipleVisiteMedicaleResolver } },
        { path: 'new', component: VisiteMedicaleNewComponent },
        { path: ':id/edit', component: VisiteMedicaleEditComponent, resolve: { visiteMedicale: OneVisiteMedicaleResolver } },
        { path: ':id/clone', component: VisiteMedicaleCloneComponent, resolve: { visiteMedicale: OneVisiteMedicaleResolver } },
        { path: ':id', component: VisiteMedicaleShowComponent, resolve: { visiteMedicale: OneVisiteMedicaleResolver } }
    ]

};

export { visiteMedicaleRoutes }
