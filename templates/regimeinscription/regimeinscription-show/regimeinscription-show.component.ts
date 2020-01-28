import { Component, OnInit } from '@angular/core';
import { Regimeinscription } from '../regimeinscription';
import { ActivatedRoute, Router } from '@angular/router';
import { RegimeinscriptionService } from '../regimeinscription.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-regimeinscription-show',
  templateUrl: './regimeinscription-show.component.html',
  styleUrls: ['./regimeinscription-show.component.scss']
})
export class RegimeinscriptionShowComponent implements OnInit {

  regimeinscription: Regimeinscription;
  constructor(public activatedRoute: ActivatedRoute,
    public regimeinscriptionSrv: RegimeinscriptionService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.regimeinscription = this.activatedRoute.snapshot.data['regimeinscription'];
  }

  removeRegimeinscription() {
    this.regimeinscriptionSrv.remove(this.regimeinscription)
      .subscribe(data => this.router.navigate([this.regimeinscriptionSrv.getRoutePrefix()]),
        error =>  this.regimeinscriptionSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.regimeinscriptionSrv.findOneById(this.regimeinscription.id)
    .subscribe((data:any)=>this.regimeinscription=data,
      error=>this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

}

