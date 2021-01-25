import { Component, OnInit } from '@angular/core';
import { Article } from '../article';
import { ActivatedRoute, Router } from '@angular/router';
import { ArticleService } from '../article.service';
import { articleColumns, allowedArticleFieldsForFilter } from '../article.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-article-list',
  templateUrl: './article-list.component.html',
  styleUrls: ['./article-list.component.scss']
})
export class ArticleListComponent implements OnInit {

  articles: Article[] = [];
  selectedArticles: Article[];
  selectedArticle: Article;
  clonedArticles: Article[];

  cMenuItems: MenuItem[]=[];

  tableColumns = articleColumns;
  //allowed fields for filter
  globalFilterFields = allowedArticleFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public articleSrv: ArticleService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Article')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewArticle(this.selectedArticle) });
    }
    if(this.authSrv.checkEditAccess('Article')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editArticle(this.selectedArticle) })
    }
    if(this.authSrv.checkCloneAccess('Article')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneArticle(this.selectedArticle) })
    }
    if(this.authSrv.checkDeleteAccess('Article')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteArticle(this.selectedArticle) })
    }

    this.articles = this.activatedRoute.snapshot.data['articles'];
  }

  viewArticle(article: Article) {
      this.router.navigate([this.articleSrv.getRoutePrefix(), article.id]);

  }

  editArticle(article: Article) {
      this.router.navigate([this.articleSrv.getRoutePrefix(), article.id, 'edit']);
  }

  cloneArticle(article: Article) {
      this.router.navigate([this.articleSrv.getRoutePrefix(), article.id, 'clone']);
  }

  deleteArticle(article: Article) {
      this.articleSrv.remove(article)
        .subscribe(data => this.refreshList(), error => this.articleSrv.httpSrv.handleError(error));
  }

  deleteSelectedArticles(article: Article) {
    this.articleSrv.removeSelection(this.selectedArticles)
      .subscribe(data => this.refreshList(), error => this.articleSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.articleSrv.findAll()
      .subscribe((data: any) => this.articles = data, error => this.articleSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.articles, 'articles');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.articles);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}