import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { NiveauService } from './niveau.service';

@Injectable({
  providedIn: 'root'
})
export class OneNiveauResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.niveauSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ niveau: null, error: message });
    }));
  }

  constructor(public niveauSrv:NiveauService) { }
}

