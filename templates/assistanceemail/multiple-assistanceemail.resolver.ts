import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { AssistanceEmailService } from './assistanceemail.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MultipleAssistanceEmailResolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.assistanceEmailSrv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.assistanceEmailSrv.httpSrv.handleError(error);
        return of({ assistanceEmails: null, error: message });
      }));
  }

  constructor(public assistanceEmailSrv: AssistanceEmailService) { }
}

