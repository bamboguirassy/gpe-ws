import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { PaiementFraisEncadrementService } from './paiementfraisencadrement.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultiplePaiementFraisEncadrementResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.paiementFraisEncadrementSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.paiementFraisEncadrementSrv.httpSrv.handleError(error);
        return of({ paiementFraisEncadrements: null, error: message });
      }));
  }

  constructor(public paiementFraisEncadrementSrv: PaiementFraisEncadrementService) { }
}

