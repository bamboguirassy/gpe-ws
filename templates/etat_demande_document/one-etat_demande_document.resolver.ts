import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { EtatDemandeDocumentService } from './etat_demande_document.service';

@Injectable({
  providedIn: 'root'
})
export class OneEtatDemandeDocumentResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.etat_demande_documentSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ etat_demande_document: null, error: message });
    }));
  }

  constructor(public etat_demande_documentSrv:EtatDemandeDocumentService) { }
}

