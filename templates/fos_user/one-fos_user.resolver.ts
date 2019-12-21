import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { FosUserService } from './fos_user.service';

@Injectable({
  providedIn: 'root'
})
export class OneFosUserResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.fos_userSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ fos_user: null, error: message });
    }));
  }

  constructor(public fos_userSrv:FosUserService) { }
}

