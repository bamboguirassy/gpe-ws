import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { EtatReclamationBourseService } from './etat_reclamation_bourse.service';

@Injectable({
  providedIn: 'root'
})
export class OneEtatReclamationBourseResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.etat_reclamation_bourseSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ etat_reclamation_bourse: null, error: message });
    }));
  }

  constructor(public etat_reclamation_bourseSrv:EtatReclamationBourseService) { }
}

