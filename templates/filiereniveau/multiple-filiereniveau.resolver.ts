import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { FiliereniveauService } from './filiereniveau.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleFiliereniveauResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.filiereniveauSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.filiereniveauSrv.httpSrv.handleError(error);
        return of({ filiereniveaus: null, error: message });
      }));
  }

  constructor(public filiereniveauSrv: FiliereniveauService) { }
}

