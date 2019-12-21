import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { InscriptionacadService } from './inscriptionacad.service';

@Injectable({
  providedIn: 'root'
})
export class OneInscriptionacadResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.inscriptionacadSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ inscriptionacad: null, error: message });
    }));
  }

  constructor(public inscriptionacadSrv:InscriptionacadService) { }
}

