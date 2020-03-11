
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Anneeacad } from './anneeacad';

@Injectable({
  providedIn: 'root'
})
export class AnneeacadService {

  private routePrefix: string = 'anneeacad';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(anneeacad: Anneeacad) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', anneeacad);
  }

  update(anneeacad: Anneeacad) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+anneeacad.id+'/edit', anneeacad);
  }

  clone(original: Anneeacad, clone: Anneeacad) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(anneeacad: Anneeacad) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+anneeacad.id);
  }

  removeSelection(anneeacads: Anneeacad[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',anneeacads);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
