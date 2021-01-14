import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { HistoriqueEtatReclamationService } from './historique_etat_reclamation.service';

@Injectable({
  providedIn: 'root'
})
export class OneHistoriqueEtatReclamationResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.historique_etat_reclamationSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ historique_etat_reclamation: null, error: message });
    }));
  }

  constructor(public historique_etat_reclamationSrv:HistoriqueEtatReclamationService) { }
}

