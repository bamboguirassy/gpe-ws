
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { HistoriqueEtatDemande } from './historique_etat_demande';

@Injectable({
  providedIn: 'root'
})
export class HistoriqueEtatDemandeService {

  private routePrefix: string = 'historique_etat_demande';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(historique_etat_demande: HistoriqueEtatDemande) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', historique_etat_demande);
  }

  update(historique_etat_demande: HistoriqueEtatDemande) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+historique_etat_demande.id+'/edit', historique_etat_demande);
  }

  clone(original: HistoriqueEtatDemande, clone: HistoriqueEtatDemande) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(historique_etat_demande: HistoriqueEtatDemande) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+historique_etat_demande.id);
  }

  removeSelection(historique_etat_demandes: HistoriqueEtatDemande[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',historique_etat_demandes);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
