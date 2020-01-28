import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { PaysService } from './pays.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultiplePaysResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.paySrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.paySrv.httpSrv.handleError(error);
        return of({ pays: null, error: message });
      }));
  }

  constructor(public paySrv: PaysService) { }
}

