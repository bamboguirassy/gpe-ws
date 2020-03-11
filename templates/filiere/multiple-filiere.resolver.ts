import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { FiliereService } from './filiere.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleFiliereResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.filiereSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.filiereSrv.httpSrv.handleError(error);
        return of({ filieres: null, error: message });
      }));
  }

  constructor(public filiereSrv: FiliereService) { }
}

