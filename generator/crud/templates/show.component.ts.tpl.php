import { Component, OnInit } from '@angular/core';
import { <?= $entity_class_name ?> } from '../<?= strtolower($entity_class_name) ?>';
import { ActivatedRoute, Router } from '@angular/router';
import { <?= $entity_class_name ?>Service } from '../<?= strtolower($entity_class_name) ?>.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-<?= strtolower($entity_class_name) ?>-show',
  templateUrl: './<?= strtolower($entity_class_name) ?>-show.component.html',
  styleUrls: ['./<?= strtolower($entity_class_name) ?>-show.component.scss']
})
export class <?= $entity_class_name ?>ShowComponent implements OnInit {

  <?= $entity_var_singular ?>: <?= $entity_class_name ?>;
  constructor(public activatedRoute: ActivatedRoute,
    public <?= $entity_var_singular ?>Srv: <?= $entity_class_name ?>Service, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.<?= $entity_var_singular ?> = this.activatedRoute.snapshot.data['<?= $entity_var_singular ?>'];
  }

  remove<?= $entity_class_name ?>() {
    this.<?= $entity_var_singular ?>Srv.remove(this.<?= $entity_var_singular ?>)
      .subscribe(data => this.router.navigate([this.<?= $entity_var_singular ?>Srv.getRoutePrefix()]),
        error =>  this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.<?= $entity_var_singular ?>Srv.findOneById(this.<?= $entity_var_singular ?>.id)
    .subscribe((data:any)=>this.<?= $entity_var_singular ?>=data,
      error=>this.<?= $entity_var_singular ?>Srv.httpSrv.handleError(error));
  }

}

