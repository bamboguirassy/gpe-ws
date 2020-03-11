import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { AnneeacadService } from './anneeacad.service';

@Injectable({
  providedIn: 'root'
})
export class OneAnneeacadResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.anneeacadSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ anneeacad: null, error: message });
    }));
  }

  constructor(public anneeacadSrv:AnneeacadService) { }
}

