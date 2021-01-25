import { Route } from "@angular/router";
import { ArticleListComponent } from './article-list/article-list.component';
import { ArticleNewComponent } from './article-new/article-new.component';
import { ArticleEditComponent } from './article-edit/article-edit.component';
import { ArticleCloneComponent } from './article-clone/article-clone.component';
import { ArticleShowComponent } from './article-show/article-show.component';
import { MultipleArticleResolver } from './multiple-article.resolver';
import { OneArticleResolver } from './one-article.resolver';

const articleRoutes: Route = {
    path: 'article', children: [
        { path: '', component: ArticleListComponent, resolve: { articles: MultipleArticleResolver } },
        { path: 'new', component: ArticleNewComponent },
        { path: ':id/edit', component: ArticleEditComponent, resolve: { article: OneArticleResolver } },
        { path: ':id/clone', component: ArticleCloneComponent, resolve: { article: OneArticleResolver } },
        { path: ':id', component: ArticleShowComponent, resolve: { article: OneArticleResolver } }
    ]

};

export { articleRoutes }
