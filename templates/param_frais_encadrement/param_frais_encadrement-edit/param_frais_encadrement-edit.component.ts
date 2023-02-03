
import { Component, OnInit } from '@angular/core';
import { ParamFraisEncadrementService } from '../paramfraisencadrement.service';
import { ParamFraisEncadrement } from '../paramfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-paramfraisencadrement-edit',
  templateUrl: './paramfraisencadrement-edit.component.html',
  styleUrls: ['./paramfraisencadrement-edit.component.scss']
})
export class ParamFraisEncadrementEditComponent implements OnInit {

  paramFraisEncadrement: ParamFraisEncadrement;
  constructor(public paramFraisEncadrementSrv: ParamFraisEncadrementService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.paramFraisEncadrement = this.activatedRoute.snapshot.data['paramFraisEncadrement'];
  }

  updateParamFraisEncadrement() {
    this.paramFraisEncadrementSrv.update(this.paramFraisEncadrement)
      .subscribe(data => this.location.back(),
        error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

}
