import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { SpecialiteService } from './specialite.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleSpecialiteResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.specialiteSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.specialiteSrv.httpSrv.handleError(error);
        return of({ specialites: null, error: message });
      }));
  }

  constructor(public specialiteSrv: SpecialiteService) { }
}

