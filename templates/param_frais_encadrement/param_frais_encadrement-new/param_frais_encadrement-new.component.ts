import { Component, OnInit } from '@angular/core';
import { ParamFraisEncadrement } from '../paramfraisencadrement';
import { ParamFraisEncadrementService } from '../paramfraisencadrement.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-paramfraisencadrement-new',
  templateUrl: './paramfraisencadrement-new.component.html',
  styleUrls: ['./paramfraisencadrement-new.component.scss']
})
export class ParamFraisEncadrementNewComponent implements OnInit {
  paramFraisEncadrement: ParamFraisEncadrement;
  constructor(public paramFraisEncadrementSrv: ParamFraisEncadrementService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.paramFraisEncadrement = new ParamFraisEncadrement();
  }

  ngOnInit() {
  }

  saveParamFraisEncadrement() {
    this.paramFraisEncadrementSrv.create(this.paramFraisEncadrement)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('ParamFraisEncadrement créé avec succès');
        this.paramFraisEncadrement = new ParamFraisEncadrement();
      }, error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

  saveParamFraisEncadrementAndExit() {
    this.paramFraisEncadrementSrv.create(this.paramFraisEncadrement)
      .subscribe((data: any) => {
        this.router.navigate([this.paramFraisEncadrementSrv.getRoutePrefix(), data.id]);
      }, error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

}

