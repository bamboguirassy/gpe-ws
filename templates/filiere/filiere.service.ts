
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Filiere } from './filiere';

@Injectable({
  providedIn: 'root'
})
export class FiliereService {

  private routePrefix: string = 'filiere';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(filiere: Filiere) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', filiere);
  }

  update(filiere: Filiere) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+filiere.id+'/edit', filiere);
  }

  clone(original: Filiere, clone: Filiere) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(filiere: Filiere) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+filiere.id);
  }

  removeSelection(filieres: Filiere[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',filieres);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
