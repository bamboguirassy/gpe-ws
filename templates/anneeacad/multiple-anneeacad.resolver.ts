import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { AnneeacadService } from './anneeacad.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleAnneeacadResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.anneeacadSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.anneeacadSrv.httpSrv.handleError(error);
        return of({ anneeacads: null, error: message });
      }));
  }

  constructor(public anneeacadSrv: AnneeacadService) { }
}

