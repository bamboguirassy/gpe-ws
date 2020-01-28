
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Pays } from './pays';

@Injectable({
  providedIn: 'root'
})
export class PaysService {

  private routePrefix: string = 'pays';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(pay: Pays) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', pay);
  }

  update(pay: Pays) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+pay.id+'/edit', pay);
  }

  clone(original: Pays, clone: Pays) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(pay: Pays) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+pay.id);
  }

  removeSelection(pays: Pays[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',pays);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
