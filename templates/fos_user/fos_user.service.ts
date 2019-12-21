
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { FosUser } from './fos_user';

@Injectable({
  providedIn: 'root'
})
export class FosUserService {

  private routePrefix: string = 'fos_user';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(fos_user: FosUser) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', fos_user);
  }

  update(fos_user: FosUser) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+fos_user.id+'/edit', fos_user);
  }

  clone(original: FosUser, clone: FosUser) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(fos_user: FosUser) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+fos_user.id);
  }

  removeSelection(fos_users: FosUser[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',fos_users);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
