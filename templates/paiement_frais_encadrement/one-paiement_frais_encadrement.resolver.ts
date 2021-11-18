import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { PaiementFraisEncadrementService } from './paiementfraisencadrement.service';

@Injectable({
  providedIn: 'root'
})
export class OnePaiementFraisEncadrementResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.paiementFraisEncadrementSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ paiementFraisEncadrement: null, error: message });
    }));
  }

  constructor(public paiementFraisEncadrementSrv:PaiementFraisEncadrementService) { }
}

