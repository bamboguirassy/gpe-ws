import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { EtatReclamationBourseService } from './etat_reclamation_bourse.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleEtatReclamationBourseResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.etat_reclamation_bourseSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.etat_reclamation_bourseSrv.httpSrv.handleError(error);
        return of({ etat_reclamation_bourses: null, error: message });
      }));
  }

  constructor(public etat_reclamation_bourseSrv: EtatReclamationBourseService) { }
}

