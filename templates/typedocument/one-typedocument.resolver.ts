import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';
import { TypedocumentService } from './typedocument.service';

@Injectable({
  providedIn: 'root'
})
export class OneTypedocumentResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot) {
    return this.typedocumentSrv.findOneById(route.params.id).pipe(map(data => {
      return data;
    }),
    catchError(error => {
      const message = `Retrieval error: ${error}`;
      return of({ typedocument: null, error: message });
    }));
  }

  constructor(public typedocumentSrv:TypedocumentService) { }
}

