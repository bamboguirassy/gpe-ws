import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { ReclamationBourseService } from './reclamation_bourse.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleReclamationBourseResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.reclamation_bourseSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.reclamation_bourseSrv.httpSrv.handleError(error);
        return of({ reclamation_bourses: null, error: message });
      }));
  }

  constructor(public reclamation_bourseSrv: ReclamationBourseService) { }
}

