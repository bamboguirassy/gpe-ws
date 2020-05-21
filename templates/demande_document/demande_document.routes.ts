import { Route } from "@angular/router";
import { DemandeDocumentListComponent } from './demande_document-list/demande_document-list.component';
import { DemandeDocumentNewComponent } from './demande_document-new/demande_document-new.component';
import { DemandeDocumentEditComponent } from './demande_document-edit/demande_document-edit.component';
import { DemandeDocumentCloneComponent } from './demande_document-clone/demande_document-clone.component';
import { DemandeDocumentShowComponent } from './demande_document-show/demande_document-show.component';
import { MultipleDemandeDocumentResolver } from './multiple-demande_document.resolver';
import { OneDemandeDocumentResolver } from './one-demande_document.resolver';

const demande_documentRoutes: Route = {
    path: 'demande_document', children: [
        { path: '', component: DemandeDocumentListComponent, resolve: { demande_documents: MultipleDemandeDocumentResolver } },
        { path: 'new', component: DemandeDocumentNewComponent },
        { path: ':id/edit', component: DemandeDocumentEditComponent, resolve: { demande_document: OneDemandeDocumentResolver } },
        { path: ':id/clone', component: DemandeDocumentCloneComponent, resolve: { demande_document: OneDemandeDocumentResolver } },
        { path: ':id', component: DemandeDocumentShowComponent, resolve: { demande_document: OneDemandeDocumentResolver } }
    ]

};

export { demande_documentRoutes }
