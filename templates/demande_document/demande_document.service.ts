
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { DemandeDocument } from './demande_document';

@Injectable({
  providedIn: 'root'
})
export class DemandeDocumentService {

  private routePrefix: string = 'demande_document';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(demande_document: DemandeDocument) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', demande_document);
  }

  update(demande_document: DemandeDocument) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+demande_document.id+'/edit', demande_document);
  }

  clone(original: DemandeDocument, clone: DemandeDocument) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(demande_document: DemandeDocument) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+demande_document.id);
  }

  removeSelection(demande_documents: DemandeDocument[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',demande_documents);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
