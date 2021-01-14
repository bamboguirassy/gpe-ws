import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { TypedocumentService } from './typedocument.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleTypedocumentResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.typedocumentSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.typedocumentSrv.httpSrv.handleError(error);
        return of({ typedocuments: null, error: message });
      }));
  }

  constructor(public typedocumentSrv: TypedocumentService) { }
}

