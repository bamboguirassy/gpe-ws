
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Article } from './article';

@Injectable({
  providedIn: 'root'
})
export class ArticleService {

  private routePrefix = 'article';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(article: Article) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', article);
  }

  update(article: Article) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+article.id+'/edit', article);
  }

  clone(original: Article, clone: Article) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(article: Article) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+article.id);
  }

  removeSelection(articles: Article[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',articles);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
