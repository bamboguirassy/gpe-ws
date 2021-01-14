import { Route } from "@angular/router";
import { TypedocumentListComponent } from './typedocument-list/typedocument-list.component';
import { TypedocumentNewComponent } from './typedocument-new/typedocument-new.component';
import { TypedocumentEditComponent } from './typedocument-edit/typedocument-edit.component';
import { TypedocumentCloneComponent } from './typedocument-clone/typedocument-clone.component';
import { TypedocumentShowComponent } from './typedocument-show/typedocument-show.component';
import { MultipleTypedocumentResolver } from './multiple-typedocument.resolver';
import { OneTypedocumentResolver } from './one-typedocument.resolver';

const typedocumentRoutes: Route = {
    path: 'typedocument', children: [
        { path: '', component: TypedocumentListComponent, resolve: { typedocuments: MultipleTypedocumentResolver } },
        { path: 'new', component: TypedocumentNewComponent },
        { path: ':id/edit', component: TypedocumentEditComponent, resolve: { typedocument: OneTypedocumentResolver } },
        { path: ':id/clone', component: TypedocumentCloneComponent, resolve: { typedocument: OneTypedocumentResolver } },
        { path: ':id', component: TypedocumentShowComponent, resolve: { typedocument: OneTypedocumentResolver } }
    ]

};

export { typedocumentRoutes }
