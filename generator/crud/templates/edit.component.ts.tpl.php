
import { Component, OnInit } from '@angular/core';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-edit',
  templateUrl: './<?= strtolower($entity_class_name) ?>-edit.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-edit.component.scss']
})
export class <?= $entity_class_name ?>EditComponent implements OnInit {

  <?= $entity_var_singular ?>: <?= $entity_class_name ?>;
  constructor(public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.<?= $entity_var_singular ?> = this.activatedRoute.snapshot.data['<?= $entity_var_singular ?>'];
  }

  update<?= $entity_class_name ?>() {
    this.<?= $entity_var_singular ?>Srv.update(this.<?= $entity_var_singular ?>)
      .subscribe(data => this.location.back(),
        error => this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error));
  }

}
