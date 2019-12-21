import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { FosUserService } from './fos_user.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleFosUserResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.fos_userSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.fos_userSrv.httpSrv.handleError(error);
        return of({ fos_users: null, error: message });
      }));
  }

  constructor(public fos_userSrv: FosUserService) { }
}

