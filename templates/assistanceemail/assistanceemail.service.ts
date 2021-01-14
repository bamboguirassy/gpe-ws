
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { AssistanceEmail } from './assistanceemail';

@Injectable({
  providedIn: 'root'
})
export class AssistanceEmailService {

  private routePrefix = 'assistanceemail';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(assistanceEmail: AssistanceEmail) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', assistanceEmail);
  }

  update(assistanceEmail: AssistanceEmail) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+assistanceEmail.id+'/edit', assistanceEmail);
  }

  clone(original: AssistanceEmail, clone: AssistanceEmail) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(assistanceEmail: AssistanceEmail) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+assistanceEmail.id);
  }

  removeSelection(assistanceEmails: AssistanceEmail[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',assistanceEmails);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
