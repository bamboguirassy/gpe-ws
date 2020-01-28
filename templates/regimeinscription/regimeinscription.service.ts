
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Regimeinscription } from './regimeinscription';

@Injectable({
  providedIn: 'root'
})
export class RegimeinscriptionService {

  private routePrefix: string = 'regimeinscription';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(regimeinscription: Regimeinscription) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', regimeinscription);
  }

  update(regimeinscription: Regimeinscription) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+regimeinscription.id+'/edit', regimeinscription);
  }

  clone(original: Regimeinscription, clone: Regimeinscription) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(regimeinscription: Regimeinscription) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+regimeinscription.id);
  }

  removeSelection(regimeinscriptions: Regimeinscription[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',regimeinscriptions);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
