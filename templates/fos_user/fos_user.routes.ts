import { Route } from "@angular/router";
import { FosUserListComponent } from './fos_user-list/fos_user-list.component';
import { FosUserNewComponent } from './fos_user-new/fos_user-new.component';
import { FosUserEditComponent } from './fos_user-edit/fos_user-edit.component';
import { FosUserCloneComponent } from './fos_user-clone/fos_user-clone.component';
import { FosUserShowComponent } from './fos_user-show/fos_user-show.component';
import { MultipleFosUserResolver } from './multiple-fos_user.resolver';
import { OneFosUserResolver } from './one-fos_user.resolver';

const fos_userRoutes: Route = {
    path: 'fos_user', children: [
        { path: '', component: FosUserListComponent, resolve: { fos_users: MultipleFosUserResolver } },
        { path: 'new', component: FosUserNewComponent },
        { path: ':id/edit', component: FosUserEditComponent, resolve: { fos_user: OneFosUserResolver } },
        { path: ':id/clone', component: FosUserCloneComponent, resolve: { fos_user: OneFosUserResolver } },
        { path: ':id', component: FosUserShowComponent, resolve: { fos_user: OneFosUserResolver } }
    ]

};

export { fos_userRoutes }
