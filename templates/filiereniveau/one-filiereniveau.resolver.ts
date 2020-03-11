import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { FiliereniveauService } from './filiereniveau.service';

@Injectable({
  providedIn: 'root'
})
export class OneFiliereniveauResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.filiereniveauSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ filiereniveau: null, error: message });
    }));
  }

  constructor(public filiereniveauSrv:FiliereniveauService) { }
}

