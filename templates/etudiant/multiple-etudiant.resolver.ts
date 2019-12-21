import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { EtudiantService } from './etudiant.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleEtudiantResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.etudiantSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.etudiantSrv.httpSrv.handleError(error);
        return of({ etudiants: null, error: message });
      }));
  }

  constructor(public etudiantSrv: EtudiantService) { }
}

