
import { Injectable } from '@angular/core';
import { HttpService } from 'src/app/shared/services/http.service';
import { <?= $entity_class_name ?> } from './<?= strtolower($entity_class_name) ?>';

@Injectable({
  providedIn: 'root'
})
export class <?= $entity_class_name ?>Service {

  private routePrefix = '<?= strtolower($entity_class_name) ?>';

  constructor(public httpSrv: HttpService) { }

  findAll() {
    return this.httpSrv.get(this.getRoutePrefixWithSlash());
  }

  findOneById(id: number) {
    return this.httpSrv.get(this.getRoutePrefixWithSlash() + id);
  }

  create(<?= $entity_var_singular ?>: <?= $entity_class_name ?>) {
    return this.httpSrv.post(this.getRoutePrefixWithSlash() + 'create', <?= $entity_var_singular ?>);
  }

  update(<?= $entity_var_singular ?>: <?= $entity_class_name ?>) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+<?= $entity_var_singular ?>.id+'/edit', <?= $entity_var_singular ?>);
  }

  clone(original: <?= $entity_class_name ?>, clone: <?= $entity_class_name ?>) {
    return this.httpSrv.put(this.getRoutePrefixWithSlash()+original.id+'/clone', clone);
  }

  remove(<?= $entity_var_singular ?>: <?= $entity_class_name ?>) {
    return this.httpSrv.delete(this.getRoutePrefixWithSlash()+<?= $entity_var_singular ?>.id);
  }

  removeSelection(<?= $entity_var_singular ?>s: <?= $entity_class_name ?>[]) {
    return this.httpSrv.deleteMultiple(this.getRoutePrefixWithSlash()+'delete-selection/',<?= $entity_var_singular ?>s);
  }

  public getRoutePrefix(): string {
    return this.routePrefix;
  }

  private getRoutePrefixWithSlash(): string {
    return this.routePrefix+'/';
  }

}
