import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { InscriptionacadService } from './inscriptionacad.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleInscriptionacadResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.inscriptionacadSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.inscriptionacadSrv.httpSrv.handleError(error);
        return of({ inscriptionacads: null, error: message });
      }));
  }

  constructor(public inscriptionacadSrv: InscriptionacadService) { }
}

