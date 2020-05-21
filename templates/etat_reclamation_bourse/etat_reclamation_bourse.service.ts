
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { EtatReclamationBourse } from './etat_reclamation_bourse';

@Injectable({
  providedIn: 'root'
})
export class EtatReclamationBourseService {

  private routePrefix: string = 'etat_reclamation_bourse';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(etat_reclamation_bourse: EtatReclamationBourse) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', etat_reclamation_bourse);
  }

  update(etat_reclamation_bourse: EtatReclamationBourse) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+etat_reclamation_bourse.id+'/edit', etat_reclamation_bourse);
  }

  clone(original: EtatReclamationBourse, clone: EtatReclamationBourse) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(etat_reclamation_bourse: EtatReclamationBourse) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+etat_reclamation_bourse.id);
  }

  removeSelection(etat_reclamation_bourses: EtatReclamationBourse[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',etat_reclamation_bourses);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
