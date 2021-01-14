
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Modepaiement } from './modepaiement';

@Injectable({
  providedIn: 'root'
})
export class ModepaiementService {

  private routePrefix = 'modepaiement';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(modepaiement: Modepaiement) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', modepaiement);
  }

  update(modepaiement: Modepaiement) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+modepaiement.id+'/edit', modepaiement);
  }

  clone(original: Modepaiement, clone: Modepaiement) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(modepaiement: Modepaiement) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+modepaiement.id);
  }

  removeSelection(modepaiements: Modepaiement[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',modepaiements);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
