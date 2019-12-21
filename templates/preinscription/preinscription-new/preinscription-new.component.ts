import { Component, OnInit } from '@angular/core';
import { Preinscription } from '../preinscription';
import { PreinscriptionService } from '../preinscription.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-preinscription-new',
  templateUrl: './preinscription-new.component.html',
  styleUrls: ['./preinscription-new.component.scss']
})
export class PreinscriptionNewComponent implements OnInit {
  preinscription: Preinscription;
  constructor(public preinscriptionSrv: PreinscriptionService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.preinscription = new Preinscription();
  }

  ngOnInit() {
  }

  savePreinscription() {
    this.preinscriptionSrv.create(this.preinscription)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Preinscription créé avec succès');
        this.preinscription = new Preinscription();
      }, error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

  savePreinscriptionAndExit() {
    this.preinscriptionSrv.create(this.preinscription)
      .subscribe((data: any) => {
        this.router.navigate([this.preinscriptionSrv.getRoutePrefix(), data.id]);
      }, error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

}

