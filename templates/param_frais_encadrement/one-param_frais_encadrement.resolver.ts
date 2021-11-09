import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { ParamFraisEncadrementService } from './paramfraisencadrement.service';

@Injectable({
  providedIn: 'root'
})
export class OneParamFraisEncadrementResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.paramFraisEncadrementSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ paramFraisEncadrement: null, error: message });
    }));
  }

  constructor(public paramFraisEncadrementSrv:ParamFraisEncadrementService) { }
}

