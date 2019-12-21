
import { Component, OnInit } from '@angular/core';
import { FosUserService } from '../fos_user.service';
import { FosUser } from '../fos_user';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-fos_user-edit',
  templateUrl: './fos_user-edit.component.html',
  styleUrls: ['./fos_user-edit.component.scss']
})
export class FosUserEditComponent implements OnInit {

  fos_user: FosUser;
  constructor(public fos_userSrv: FosUserService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.fos_user = this.activatedRoute.snapshot.data['fos_user'];
  }

  updateFosUser() {
    this.fos_userSrv.update(this.fos_user)
      .subscribe(data => this.location.back(),
        error => this.fos_userSrv.httpSrv.handleError(error));
  }

}
