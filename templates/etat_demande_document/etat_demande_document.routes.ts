import { Route } from "@angular/router";
import { EtatDemandeDocumentListComponent } from './etat_demande_document-list/etat_demande_document-list.component';
import { EtatDemandeDocumentNewComponent } from './etat_demande_document-new/etat_demande_document-new.component';
import { EtatDemandeDocumentEditComponent } from './etat_demande_document-edit/etat_demande_document-edit.component';
import { EtatDemandeDocumentCloneComponent } from './etat_demande_document-clone/etat_demande_document-clone.component';
import { EtatDemandeDocumentShowComponent } from './etat_demande_document-show/etat_demande_document-show.component';
import { MultipleEtatDemandeDocumentResolver } from './multiple-etat_demande_document.resolver';
import { OneEtatDemandeDocumentResolver } from './one-etat_demande_document.resolver';

const etat_demande_documentRoutes: Route = {
    path: 'etat_demande_document', children: [
        { path: '', component: EtatDemandeDocumentListComponent, resolve: { etat_demande_documents: MultipleEtatDemandeDocumentResolver } },
        { path: 'new', component: EtatDemandeDocumentNewComponent },
        { path: ':id/edit', component: EtatDemandeDocumentEditComponent, resolve: { etat_demande_document: OneEtatDemandeDocumentResolver } },
        { path: ':id/clone', component: EtatDemandeDocumentCloneComponent, resolve: { etat_demande_document: OneEtatDemandeDocumentResolver } },
        { path: ':id', component: EtatDemandeDocumentShowComponent, resolve: { etat_demande_document: OneEtatDemandeDocumentResolver } }
    ]

};

export { etat_demande_documentRoutes }
