import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { PreinscriptionService } from './preinscription.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultiplePreinscriptionResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.preinscriptionSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.preinscriptionSrv.httpSrv.handleError(error);
        return of({ preinscriptions: null, error: message });
      }));
  }

  constructor(public preinscriptionSrv: PreinscriptionService) { }
}

