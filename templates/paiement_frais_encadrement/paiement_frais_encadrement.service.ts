
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { PaiementFraisEncadrement } from './paiementfraisencadrement';

@Injectable({
  providedIn: 'root'
})
export class PaiementFraisEncadrementService {

  private routePrefix = 'paiementfraisencadrement';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(paiement_frais_encadrement: PaiementFraisEncadrement) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', paiement_frais_encadrement);
  }

  update(paiement_frais_encadrement: PaiementFraisEncadrement) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+paiement_frais_encadrement.id+'/edit', paiement_frais_encadrement);
  }

  clone(original: PaiementFraisEncadrement, clone: PaiementFraisEncadrement) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(paiement_frais_encadrement: PaiementFraisEncadrement) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+paiement_frais_encadrement.id);
  }

  removeSelection(paiement_frais_encadrements: PaiementFraisEncadrement[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',paiement_frais_encadrements);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
