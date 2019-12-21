
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Preinscription } from './preinscription';

@Injectable({
  providedIn: 'root'
})
export class PreinscriptionService {

  private routePrefix: string = 'preinscription';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(preinscription: Preinscription) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', preinscription);
  }

  update(preinscription: Preinscription) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+preinscription.id+'/edit', preinscription);
  }

  clone(original: Preinscription, clone: Preinscription) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(preinscription: Preinscription) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+preinscription.id);
  }

  removeSelection(preinscriptions: Preinscription[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',preinscriptions);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
