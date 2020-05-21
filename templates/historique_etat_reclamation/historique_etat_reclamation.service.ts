
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { HistoriqueEtatReclamation } from './historique_etat_reclamation';

@Injectable({
  providedIn: 'root'
})
export class HistoriqueEtatReclamationService {

  private routePrefix: string = 'historique_etat_reclamation';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(historique_etat_reclamation: HistoriqueEtatReclamation) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', historique_etat_reclamation);
  }

  update(historique_etat_reclamation: HistoriqueEtatReclamation) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+historique_etat_reclamation.id+'/edit', historique_etat_reclamation);
  }

  clone(original: HistoriqueEtatReclamation, clone: HistoriqueEtatReclamation) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(historique_etat_reclamation: HistoriqueEtatReclamation) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+historique_etat_reclamation.id);
  }

  removeSelection(historique_etat_reclamations: HistoriqueEtatReclamation[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',historique_etat_reclamations);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
