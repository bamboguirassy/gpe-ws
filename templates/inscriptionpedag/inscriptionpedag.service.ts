
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Inscriptionpedag } from './inscriptionpedag';

@Injectable({
  providedIn: 'root'
})
export class InscriptionpedagService {

  private routePrefix: string = 'inscriptionpedag';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(inscriptionpedag: Inscriptionpedag) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', inscriptionpedag);
  }

  update(inscriptionpedag: Inscriptionpedag) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+inscriptionpedag.id+'/edit', inscriptionpedag);
  }

  clone(original: Inscriptionpedag, clone: Inscriptionpedag) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(inscriptionpedag: Inscriptionpedag) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+inscriptionpedag.id);
  }

  removeSelection(inscriptionpedags: Inscriptionpedag[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',inscriptionpedags);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
