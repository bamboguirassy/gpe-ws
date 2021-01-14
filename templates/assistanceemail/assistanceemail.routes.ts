import { Route } from "@angular/router";
import { AssistanceEmailListComponent } from './assistanceemail-list/assistanceemail-list.component';
import { AssistanceEmailNewComponent } from './assistanceemail-new/assistanceemail-new.component';
import { AssistanceEmailEditComponent } from './assistanceemail-edit/assistanceemail-edit.component';
import { AssistanceEmailCloneComponent } from './assistanceemail-clone/assistanceemail-clone.component';
import { AssistanceEmailShowComponent } from './assistanceemail-show/assistanceemail-show.component';
import { MultipleAssistanceEmailResolver } from './multiple-assistanceemail.resolver';
import { OneAssistanceEmailResolver } from './one-assistanceemail.resolver';

const assistanceEmailRoutes: Route = {
    path: 'assistanceemail', children: [
        { path: '', component: AssistanceEmailListComponent, resolve: { assistanceEmails: MultipleAssistanceEmailResolver } },
        { path: 'new', component: AssistanceEmailNewComponent },
        { path: ':id/edit', component: AssistanceEmailEditComponent, resolve: { assistanceEmail: OneAssistanceEmailResolver } },
        { path: ':id/clone', component: AssistanceEmailCloneComponent, resolve: { assistanceEmail: OneAssistanceEmailResolver } },
        { path: ':id', component: AssistanceEmailShowComponent, resolve: { assistanceEmail: OneAssistanceEmailResolver } }
    ]

};

export { assistanceEmailRoutes }
