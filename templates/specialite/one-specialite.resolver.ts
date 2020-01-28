import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { SpecialiteService } from './specialite.service';

@Injectable({
  providedIn: 'root'
})
export class OneSpecialiteResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.specialiteSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ specialite: null, error: message });
    }));
  }

  constructor(public specialiteSrv:SpecialiteService) { }
}

