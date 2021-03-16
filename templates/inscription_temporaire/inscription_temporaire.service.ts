
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { InscriptionTemporaire } from './inscriptiontemporaire';

@Injectable({
  providedIn: 'root'
})
export class InscriptionTemporaireService {

  private routePrefix = 'inscriptiontemporaire';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(inscription_temporaire: InscriptionTemporaire) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', inscription_temporaire);
  }

  update(inscription_temporaire: InscriptionTemporaire) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+inscription_temporaire.id+'/edit', inscription_temporaire);
  }

  clone(original: InscriptionTemporaire, clone: InscriptionTemporaire) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(inscription_temporaire: InscriptionTemporaire) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+inscription_temporaire.id);
  }

  removeSelection(inscription_temporaires: InscriptionTemporaire[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',inscription_temporaires);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
