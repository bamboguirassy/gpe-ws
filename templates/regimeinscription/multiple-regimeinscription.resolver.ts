import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { RegimeinscriptionService } from './regimeinscription.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleRegimeinscriptionResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.regimeinscriptionSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.regimeinscriptionSrv.httpSrv.handleError(error);
        return of({ regimeinscriptions: null, error: message });
      }));
  }

  constructor(public regimeinscriptionSrv: RegimeinscriptionService) { }
}

