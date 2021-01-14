
import { Component, OnInit } from '@angular/core';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { Location } from '@angular/common';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-clone',
  templateUrl: './<?= strtolower($entity_class_name) ?>-clone.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-clone.component.scss']
})
export class <?= $entity_class_name ?>CloneComponent implements OnInit {
  <?= $entity_var_singular ?>: <?= $entity_class_name ?>;
  original: <?= $entity_class_name ?>;
  constructor(public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['<?= $entity_var_singular ?>'];
    this.<?= $entity_var_singular ?> = Object.assign({}, this.original);
    this.<?= $entity_var_singular ?>.id = null;
  }

  clone<?= $entity_class_name ?>() {
    console.log(this.<?= $entity_var_singular ?>);
    this.<?= $entity_var_singular ?>Srv.clone(this.original, this.<?= $entity_var_singular ?>)
      .subscribe((data: any) => {
        this.router.navigate([this.<?= $entity_var_singular ?>Srv.getRoutePrefix(), data.id]);
      }, error => this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error));
  }

}
