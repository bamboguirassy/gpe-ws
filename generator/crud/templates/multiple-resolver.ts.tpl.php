import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { <?= $entity_class_name ?>Service } from './<?= strtolower($entity_class_name) ?>.service';
import { map, catchError } from 'rxjs/operators';
import { of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class Multiple<?= $entity_class_name ?>Resolver implements Resolve<any> {
  resolve(route: import("@angular/router").ActivatedRouteSnapshot, state: import("@angular/router").RouterStateSnapshot): any | import("rxjs").Observable<any> | Promise<any> {
    return this.<?= $entity_var_singular ?>Srv.findAll().pipe(map(data => {
      return data;
    }),
      catchError(error => {
        const message = `Retrieval error: ${error}`;
        this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error);
        return of({ <?= $entity_var_singular ?>s: null, error: message });
      }));
  }

  constructor(public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service) { }
}

