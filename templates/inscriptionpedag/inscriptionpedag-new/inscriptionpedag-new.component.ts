import { Component, OnInit } from '@angular/core';
import { Inscriptionpedag } from '../inscriptionpedag';
import { InscriptionpedagService } from '../inscriptionpedag.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-inscriptionpedag-new',
  templateUrl: './inscriptionpedag-new.component.html',
  styleUrls: ['./inscriptionpedag-new.component.scss']
})
export class InscriptionpedagNewComponent implements OnInit {
  inscriptionpedag: Inscriptionpedag;
  constructor(public inscriptionpedagSrv: InscriptionpedagService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.inscriptionpedag = new Inscriptionpedag();
  }

  ngOnInit() {
  }

  saveInscriptionpedag() {
    this.inscriptionpedagSrv.create(this.inscriptionpedag)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Inscriptionpedag créé avec succès');
        this.inscriptionpedag = new Inscriptionpedag();
      }, error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

  saveInscriptionpedagAndExit() {
    this.inscriptionpedagSrv.create(this.inscriptionpedag)
      .subscribe((data: any) => {
        this.router.navigate([this.inscriptionpedagSrv.getRoutePrefix(), data.id]);
      }, error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

}

