import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { ArticleService } from './article.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleArticleResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.articleSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.articleSrv.httpSrv.handleError(error);
        return of({ articles: null, error: message });
      }));
  }

  constructor(public articleSrv: ArticleService) { }
}

