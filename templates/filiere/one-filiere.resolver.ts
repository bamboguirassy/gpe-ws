import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { FiliereService } from './filiere.service';

@Injectable({
  providedIn: 'root'
})
export class OneFiliereResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.filiereSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ filiere: null, error: message });
    }));
  }

  constructor(public filiereSrv:FiliereService) { }
}

