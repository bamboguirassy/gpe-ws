
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Inscriptionacad } from './inscriptionacad';

@Injectable({
  providedIn: 'root'
})
export class InscriptionacadService {

  private routePrefix: string = 'inscriptionacad';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(inscriptionacad: Inscriptionacad) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', inscriptionacad);
  }

  update(inscriptionacad: Inscriptionacad) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+inscriptionacad.id+'/edit', inscriptionacad);
  }

  clone(original: Inscriptionacad, clone: Inscriptionacad) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(inscriptionacad: Inscriptionacad) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+inscriptionacad.id);
  }

  removeSelection(inscriptionacads: Inscriptionacad[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',inscriptionacads);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
