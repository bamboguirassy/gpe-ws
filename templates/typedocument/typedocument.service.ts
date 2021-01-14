
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Typedocument } from './typedocument';

@Injectable({
  providedIn: 'root'
})
export class TypedocumentService {

  private routePrefix = 'typedocument';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(typedocument: Typedocument) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', typedocument);
  }

  update(typedocument: Typedocument) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+typedocument.id+'/edit', typedocument);
  }

  clone(original: Typedocument, clone: Typedocument) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(typedocument: Typedocument) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+typedocument.id);
  }

  removeSelection(typedocuments: Typedocument[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',typedocuments);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
