import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { InscriptionTemporaireService } from './inscriptiontemporaire.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleInscriptionTemporaireResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.inscriptionTemporaireSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.inscriptionTemporaireSrv.httpSrv.handleError(error);
        return of({ inscriptionTemporaires: null, error: message });
      }));
  }

  constructor(public inscriptionTemporaireSrv: InscriptionTemporaireService) { }
}

