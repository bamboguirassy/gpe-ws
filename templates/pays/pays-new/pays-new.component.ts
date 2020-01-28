import { Component, OnInit } from '@angular/core';
import { Pays } from '../pays';
import { PaysService } from '../pays.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-pays-new',
  templateUrl: './pays-new.component.html',
  styleUrls: ['./pays-new.component.scss']
})
export class PaysNewComponent implements OnInit {
  pay: Pays;
  constructor(public paySrv: PaysService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.pay = new Pays();
  }

  ngOnInit() {
  }

  savePays() {
    this.paySrv.create(this.pay)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Pays créé avec succès');
        this.pay = new Pays();
      }, error => this.paySrv.httpSrv.handleError(error));
  }

  savePaysAndExit() {
    this.paySrv.create(this.pay)
      .subscribe((data: any) => {
        this.router.navigate([this.paySrv.getRoutePrefix(), data.id]);
      }, error => this.paySrv.httpSrv.handleError(error));
  }

}

