
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Niveau } from './niveau';

@Injectable({
  providedIn: 'root'
})
export class NiveauService {

  private routePrefix: string = 'niveau';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(niveau: Niveau) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', niveau);
  }

  update(niveau: Niveau) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+niveau.id+'/edit', niveau);
  }

  clone(original: Niveau, clone: Niveau) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(niveau: Niveau) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+niveau.id);
  }

  removeSelection(niveaus: Niveau[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',niveaus);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
