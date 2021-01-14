
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { BourseEtudiant } from './bourse_etudiant';

@Injectable({
  providedIn: 'root'
})
export class BourseEtudiantService {

  private routePrefix: string = 'bourse_etudiant';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(bourse_etudiant: BourseEtudiant) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', bourse_etudiant);
  }

  update(bourse_etudiant: BourseEtudiant) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+bourse_etudiant.id+'/edit', bourse_etudiant);
  }

  clone(original: BourseEtudiant, clone: BourseEtudiant) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(bourse_etudiant: BourseEtudiant) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+bourse_etudiant.id);
  }

  removeSelection(bourse_etudiants: BourseEtudiant[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',bourse_etudiants);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
