import { Component, OnInit } from '@angular/core';
import { Article } from '../article';
import { ActivatedRoute, Router } from '@angular/router';
import { ArticleService } from '../article.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-article-show',
  templateUrl: './article-show.component.html',
  styleUrls: ['./article-show.component.scss']
})
export class ArticleShowComponent implements OnInit {

  article: Article;
  constructor(public activatedRoute: ActivatedRoute,
    public articleSrv: ArticleService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.article = this.activatedRoute.snapshot.data['article'];
  }

  removeArticle() {
    this.articleSrv.remove(this.article)
      .subscribe(data => this.router.navigate([this.articleSrv.getRoutePrefix()]),
        error =>  this.articleSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.articleSrv.findOneById(this.article.id)
    .subscribe((data:any)=>this.article=data,
      error=>this.articleSrv.httpSrv.handleError(error));
  }

}

