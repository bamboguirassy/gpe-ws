
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { EtatDemandeDocument } from './etat_demande_document';

@Injectable({
  providedIn: 'root'
})
export class EtatDemandeDocumentService {

  private routePrefix: string = 'etat_demande_document';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(etat_demande_document: EtatDemandeDocument) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', etat_demande_document);
  }

  update(etat_demande_document: EtatDemandeDocument) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+etat_demande_document.id+'/edit', etat_demande_document);
  }

  clone(original: EtatDemandeDocument, clone: EtatDemandeDocument) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(etat_demande_document: EtatDemandeDocument) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+etat_demande_document.id);
  }

  removeSelection(etat_demande_documents: EtatDemandeDocument[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',etat_demande_documents);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
