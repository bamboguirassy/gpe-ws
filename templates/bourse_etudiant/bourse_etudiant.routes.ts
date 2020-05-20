import { Route } from "@angular/router";
import { BourseEtudiantListComponent } from './bourse_etudiant-list/bourse_etudiant-list.component';
import { BourseEtudiantNewComponent } from './bourse_etudiant-new/bourse_etudiant-new.component';
import { BourseEtudiantEditComponent } from './bourse_etudiant-edit/bourse_etudiant-edit.component';
import { BourseEtudiantCloneComponent } from './bourse_etudiant-clone/bourse_etudiant-clone.component';
import { BourseEtudiantShowComponent } from './bourse_etudiant-show/bourse_etudiant-show.component';
import { MultipleBourseEtudiantResolver } from './multiple-bourse_etudiant.resolver';
import { OneBourseEtudiantResolver } from './one-bourse_etudiant.resolver';

const bourse_etudiantRoutes: Route = {
    path: 'bourse_etudiant', children: [
        { path: '', component: BourseEtudiantListComponent, resolve: { bourse_etudiants: MultipleBourseEtudiantResolver } },
        { path: 'new', component: BourseEtudiantNewComponent },
        { path: ':id/edit', component: BourseEtudiantEditComponent, resolve: { bourse_etudiant: OneBourseEtudiantResolver } },
        { path: ':id/clone', component: BourseEtudiantCloneComponent, resolve: { bourse_etudiant: OneBourseEtudiantResolver } },
        { path: ':id', component: BourseEtudiantShowComponent, resolve: { bourse_etudiant: OneBourseEtudiantResolver } }
    ]

};

export { bourse_etudiantRoutes }
