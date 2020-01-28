import { Component, OnInit } from '@angular/core';
import { Regimeinscription } from '../regimeinscription';
import { RegimeinscriptionService } from '../regimeinscription.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-regimeinscription-new',
  templateUrl: './regimeinscription-new.component.html',
  styleUrls: ['./regimeinscription-new.component.scss']
})
export class RegimeinscriptionNewComponent implements OnInit {
  regimeinscription: Regimeinscription;
  constructor(public regimeinscriptionSrv: RegimeinscriptionService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.regimeinscription = new Regimeinscription();
  }

  ngOnInit() {
  }

  saveRegimeinscription() {
    this.regimeinscriptionSrv.create(this.regimeinscription)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Regimeinscription créé avec succès');
        this.regimeinscription = new Regimeinscription();
      }, error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

  saveRegimeinscriptionAndExit() {
    this.regimeinscriptionSrv.create(this.regimeinscription)
      .subscribe((data: any) => {
        this.router.navigate([this.regimeinscriptionSrv.getRoutePrefix(), data.id]);
      }, error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

}

