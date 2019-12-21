import { Component, OnInit } from '@angular/core';
import { FosUser } from '../fos_user';
import { FosUserService } from '../fos_user.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-fos_user-new',
  templateUrl: './fos_user-new.component.html',
  styleUrls: ['./fos_user-new.component.scss']
})
export class FosUserNewComponent implements OnInit {
  fos_user: FosUser;
  constructor(public fos_userSrv: FosUserService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.fos_user = new FosUser();
  }

  ngOnInit() {
  }

  saveFosUser() {
    this.fos_userSrv.create(this.fos_user)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('FosUser créé avec succès');
        this.fos_user = new FosUser();
      }, error => this.fos_userSrv.httpSrv.handleError(error));
  }

  saveFosUserAndExit() {
    this.fos_userSrv.create(this.fos_user)
      .subscribe((data: any) => {
        this.router.navigate([this.fos_userSrv.getRoutePrefix(), data.id]);
      }, error => this.fos_userSrv.httpSrv.handleError(error));
  }

}

