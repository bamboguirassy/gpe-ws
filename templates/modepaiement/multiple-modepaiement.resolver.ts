import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { ModepaiementService } from './modepaiement.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleModepaiementResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.modepaiementSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.modepaiementSrv.httpSrv.handleError(error);
        return of({ modepaiements: null, error: message });
      }));
  }

  constructor(public modepaiementSrv: ModepaiementService) { }
}

