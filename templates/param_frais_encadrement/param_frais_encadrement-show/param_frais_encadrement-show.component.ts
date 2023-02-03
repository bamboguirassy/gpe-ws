import { Component, OnInit } from '@angular/core';
import { ParamFraisEncadrement } from '../paramfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';
import { ParamFraisEncadrementService } from '../paramfraisencadrement.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-paramfraisencadrement-show',
  templateUrl: './paramfraisencadrement-show.component.html',
  styleUrls: ['./paramfraisencadrement-show.component.scss']
})
export class ParamFraisEncadrementShowComponent implements OnInit {

  paramFraisEncadrement: ParamFraisEncadrement;
  constructor(public activatedRoute: ActivatedRoute,
    public paramFraisEncadrementSrv: ParamFraisEncadrementService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.paramFraisEncadrement = this.activatedRoute.snapshot.data['paramFraisEncadrement'];
  }

  removeParamFraisEncadrement() {
    this.paramFraisEncadrementSrv.remove(this.paramFraisEncadrement)
      .subscribe(data => this.router.navigate([this.paramFraisEncadrementSrv.getRoutePrefix()]),
        error =>  this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.paramFraisEncadrementSrv.findOneById(this.paramFraisEncadrement.id)
    .subscribe((data:any)=>this.paramFraisEncadrement=data,
      error=>this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

}

