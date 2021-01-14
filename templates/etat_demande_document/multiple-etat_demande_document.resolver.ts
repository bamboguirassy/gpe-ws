import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { EtatDemandeDocumentService } from './etat_demande_document.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleEtatDemandeDocumentResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.etat_demande_documentSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.etat_demande_documentSrv.httpSrv.handleError(error);
        return of({ etat_demande_documents: null, error: message });
      }));
  }

  constructor(public etat_demande_documentSrv: EtatDemandeDocumentService) { }
}

