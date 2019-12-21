import { Component, OnInit } from '@angular/core';
import { FosUser } from '../fos_user';
import { ActivatedRoute, Router } from '@angular/router';
import { FosUserService } from '../fos_user.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-fos_user-show',
  templateUrl: './fos_user-show.component.html',
  styleUrls: ['./fos_user-show.component.scss']
})
export class FosUserShowComponent implements OnInit {

  fos_user: FosUser;
  constructor(public activatedRoute: ActivatedRoute,
    public fos_userSrv: FosUserService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.fos_user = this.activatedRoute.snapshot.data['fos_user'];
  }

  removeFosUser() {
    this.fos_userSrv.remove(this.fos_user)
      .subscribe(data => this.router.navigate([this.fos_userSrv.getRoutePrefix()]),
        error =>  this.fos_userSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.fos_userSrv.findOneById(this.fos_user.id)
    .subscribe((data:any)=>this.fos_user=data,
      error=>this.fos_userSrv.httpSrv.handleError(error));
  }

}

