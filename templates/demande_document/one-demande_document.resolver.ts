import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { DemandeDocumentService } from './demande_document.service';

@Injectable({
  providedIn: 'root'
})
export class OneDemandeDocumentResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.demande_documentSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ demande_document: null, error: message });
    }));
  }

  constructor(public demande_documentSrv:DemandeDocumentService) { }
}

