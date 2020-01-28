
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Specialite } from './specialite';

@Injectable({
  providedIn: 'root'
})
export class SpecialiteService {

  private routePrefix: string = 'specialite';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(specialite: Specialite) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', specialite);
  }

  update(specialite: Specialite) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+specialite.id+'/edit', specialite);
  }

  clone(original: Specialite, clone: Specialite) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(specialite: Specialite) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+specialite.id);
  }

  removeSelection(specialites: Specialite[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',specialites);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
