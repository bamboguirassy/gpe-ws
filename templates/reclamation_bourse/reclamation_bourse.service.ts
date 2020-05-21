
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { ReclamationBourse } from './reclamation_bourse';

@Injectable({
  providedIn: 'root'
})
export class ReclamationBourseService {

  private routePrefix: string = 'reclamation_bourse';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(reclamation_bourse: ReclamationBourse) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', reclamation_bourse);
  }

  update(reclamation_bourse: ReclamationBourse) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+reclamation_bourse.id+'/edit', reclamation_bourse);
  }

  clone(original: ReclamationBourse, clone: ReclamationBourse) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(reclamation_bourse: ReclamationBourse) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+reclamation_bourse.id);
  }

  removeSelection(reclamation_bourses: ReclamationBourse[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',reclamation_bourses);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
