import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { HistoriqueEtatDemandeService } from './historique_etat_demande.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleHistoriqueEtatDemandeResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.historique_etat_demandeSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.historique_etat_demandeSrv.httpSrv.handleError(error);
        return of({ historique_etat_demandes: null, error: message });
      }));
  }

  constructor(public historique_etat_demandeSrv: HistoriqueEtatDemandeService) { }
}

