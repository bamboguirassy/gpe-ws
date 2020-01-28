
import { Component, OnInit } from '@angular/core';
import { PaysService } from '../pays.service';
import { Pays } from '../pays';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-pays-edit',
  templateUrl: './pays-edit.component.html',
  styleUrls: ['./pays-edit.component.scss']
})
export class PaysEditComponent implements OnInit {

  pay: Pays;
  constructor(public paySrv: PaysService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.pay = this.activatedRoute.snapshot.data['pay'];
  }

  updatePays() {
    this.paySrv.update(this.pay)
      .subscribe(data => this.location.back(),
        error => this.paySrv.httpSrv.handleError(error));
  }

}
