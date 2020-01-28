import { Component, OnInit } from '@angular/core';
import { Pays } from '../pays';
import { ActivatedRoute, Router } from '@angular/router';
import { PaysService } from '../pays.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-pays-show',
  templateUrl: './pays-show.component.html',
  styleUrls: ['./pays-show.component.scss']
})
export class PaysShowComponent implements OnInit {

  pay: Pays;
  constructor(public activatedRoute: ActivatedRoute,
    public paySrv: PaysService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.pay = this.activatedRoute.snapshot.data['pay'];
  }

  removePays() {
    this.paySrv.remove(this.pay)
      .subscribe(data => this.router.navigate([this.paySrv.getRoutePrefix()]),
        error =>  this.paySrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.paySrv.findOneById(this.pay.id)
    .subscribe((data:any)=>this.pay=data,
      error=>this.paySrv.httpSrv.handleError(error));
  }

}

