import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { ParamFraisEncadrementService } from './paramfraisencadrement.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleParamFraisEncadrementResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.paramFraisEncadrementSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.paramFraisEncadrementSrv.httpSrv.handleError(error);
        return of({ paramFraisEncadrements: null, error: message });
      }));
  }

  constructor(public paramFraisEncadrementSrv: ParamFraisEncadrementService) { }
}

