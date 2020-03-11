import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { NiveauService } from './niveau.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleNiveauResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.niveauSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.niveauSrv.httpSrv.handleError(error);
        return of({ niveaus: null, error: message });
      }));
  }

  constructor(public niveauSrv: NiveauService) { }
}

