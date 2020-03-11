
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Filiereniveau } from './filiereniveau';

@Injectable({
  providedIn: 'root'
})
export class FiliereniveauService {

  private routePrefix: string = 'filiereniveau';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(filiereniveau: Filiereniveau) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', filiereniveau);
  }

  update(filiereniveau: Filiereniveau) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+filiereniveau.id+'/edit', filiereniveau);
  }

  clone(original: Filiereniveau, clone: Filiereniveau) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(filiereniveau: Filiereniveau) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+filiereniveau.id);
  }

  removeSelection(filiereniveaus: Filiereniveau[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',filiereniveaus);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
