
import { Component, OnInit } from '@angular/core';
import { ArticleService } from '../article.service';
import { Location } from '@angular/common';
import { Article } from '../article';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-article-clone',
  templateUrl: './article-clone.component.html',
  styleUrls: ['./article-clone.component.scss']
})
export class ArticleCloneComponent implements OnInit {
  article: Article;
  original: Article;
  constructor(public articleSrv: ArticleService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['article'];
    this.article = Object.assign({}, this.original);
    this.article.id = null;
  }

  cloneArticle() {
    console.log(this.article);
    this.articleSrv.clone(this.original, this.article)
      .subscribe((data: any) => {
        this.router.navigate([this.articleSrv.getRoutePrefix(), data.id]);
      }, error => this.articleSrv.httpSrv.handleError(error));
  }

}
