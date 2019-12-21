import { Route } from "@angular/router";
import { EtudiantListComponent } from './etudiant-list/etudiant-list.component';
import { EtudiantNewComponent } from './etudiant-new/etudiant-new.component';
import { EtudiantEditComponent } from './etudiant-edit/etudiant-edit.component';
import { EtudiantCloneComponent } from './etudiant-clone/etudiant-clone.component';
import { EtudiantShowComponent } from './etudiant-show/etudiant-show.component';
import { MultipleEtudiantResolver } from './multiple-etudiant.resolver';
import { OneEtudiantResolver } from './one-etudiant.resolver';

const etudiantRoutes: Route = {
    path: 'etudiant', children: [
        { path: '', component: EtudiantListComponent, resolve: { etudiants: MultipleEtudiantResolver } },
        { path: 'new', component: EtudiantNewComponent },
        { path: ':id/edit', component: EtudiantEditComponent, resolve: { etudiant: OneEtudiantResolver } },
        { path: ':id/clone', component: EtudiantCloneComponent, resolve: { etudiant: OneEtudiantResolver } },
        { path: ':id', component: EtudiantShowComponent, resolve: { etudiant: OneEtudiantResolver } }
    ]

};

export { etudiantRoutes }
