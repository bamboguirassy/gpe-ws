
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { Etudiant } from './etudiant';

@Injectable({
  providedIn: 'root'
})
export class EtudiantService {

  private routePrefix: string = 'etudiant';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(etudiant: Etudiant) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', etudiant);
  }

  update(etudiant: Etudiant) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+etudiant.id+'/edit', etudiant);
  }

  clone(original: Etudiant, clone: Etudiant) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(etudiant: Etudiant) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+etudiant.id);
  }

  removeSelection(etudiants: Etudiant[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',etudiants);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
