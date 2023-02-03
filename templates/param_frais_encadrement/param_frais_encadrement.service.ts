
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { ParamFraisEncadrement } from './paramfraisencadrement';

@Injectable({
  providedIn: 'root'
})
export class ParamFraisEncadrementService {

  private routePrefix = 'paramfraisencadrement';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(param_frais_encadrement: ParamFraisEncadrement) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', param_frais_encadrement);
  }

  update(param_frais_encadrement: ParamFraisEncadrement) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+param_frais_encadrement.id+'/edit', param_frais_encadrement);
  }

  clone(original: ParamFraisEncadrement, clone: ParamFraisEncadrement) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(param_frais_encadrement: ParamFraisEncadrement) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+param_frais_encadrement.id);
  }

  removeSelection(param_frais_encadrements: ParamFraisEncadrement[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',param_frais_encadrements);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
