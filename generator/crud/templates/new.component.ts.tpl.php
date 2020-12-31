import { Component, OnInit } from '@angular/core';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-new',
  templateUrl: './<?= strtolower($entity_class_name) ?>-new.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-new.component.scss']
})
export class <?= $entity_class_name ?>NewComponent implements OnInit {
  <?= $entity_var_singular ?>: <?= $entity_class_name ?>;
  constructor(public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.<?= $entity_var_singular ?> = new <?= $entity_class_name ?>();
  }

  ngOnInit() {
  }

  save<?= $entity_class_name ?>() {
    this.<?= $entity_var_singular ?>Srv.create(this.<?= $entity_var_singular ?>)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('<?= $entity_class_name ?> créé avec succès');
        this.<?= $entity_var_singular ?> = new <?= $entity_class_name ?>();
      }, error => this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error));
  }

  save<?= $entity_class_name ?>AndExit() {
    this.<?= $entity_var_singular ?>Srv.create(this.<?= $entity_var_singular ?>)
      .subscribe((data: any) => {
        this.router.navigate([this.<?= $entity_var_singular ?>Srv.getRoutePrefix(), data.id]);
      }, error => this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error));
  }

}

