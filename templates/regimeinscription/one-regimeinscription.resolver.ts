import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { RegimeinscriptionService } from './regimeinscription.service';

@Injectable({
  providedIn: 'root'
})
export class OneRegimeinscriptionResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.regimeinscriptionSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ regimeinscription: null, error: message });
    }));
  }

  constructor(public regimeinscriptionSrv:RegimeinscriptionService) { }
}

