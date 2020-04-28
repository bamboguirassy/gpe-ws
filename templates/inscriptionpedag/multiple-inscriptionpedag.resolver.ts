import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { InscriptionpedagService } from './inscriptionpedag.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleInscriptionpedagResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.inscriptionpedagSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.inscriptionpedagSrv.httpSrv.handleError(error);
        return of({ inscriptionpedags: null, error: message });
      }));
  }

  constructor(public inscriptionpedagSrv: InscriptionpedagService) { }
}

