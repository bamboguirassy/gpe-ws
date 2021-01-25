import { Component, OnInit } from '@angular/core';
import { Article } from '../article';
import { ArticleService } from '../article.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-article-new',
  templateUrl: './article-new.component.html',
  styleUrls: ['./article-new.component.scss']
})
export class ArticleNewComponent implements OnInit {
  article: Article;
  constructor(public articleSrv: ArticleService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.article = new Article();
  }

  ngOnInit() {
  }

  saveArticle() {
    this.articleSrv.create(this.article)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Article créé avec succès');
        this.article = new Article();
      }, error => this.articleSrv.httpSrv.handleError(error));
  }

  saveArticleAndExit() {
    this.articleSrv.create(this.article)
      .subscribe((data: any) => {
        this.router.navigate([this.articleSrv.getRoutePrefix(), data.id]);
      }, error => this.articleSrv.httpSrv.handleError(error));
  }

}

