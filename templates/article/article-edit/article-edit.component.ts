
import { Component, OnInit } from '@angular/core';
import { ArticleService } from '../article.service';
import { Article } from '../article';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-article-edit',
  templateUrl: './article-edit.component.html',
  styleUrls: ['./article-edit.component.scss']
})
export class ArticleEditComponent implements OnInit {

  article: Article;
  constructor(public articleSrv: ArticleService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.article = this.activatedRoute.snapshot.data['article'];
  }

  updateArticle() {
    this.articleSrv.update(this.article)
      .subscribe(data => this.location.back(),
        error => this.articleSrv.httpSrv.handleError(error));
  }

}
