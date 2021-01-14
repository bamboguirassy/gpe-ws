import { Component, OnInit } from '@angular/core';
import { Modepaiement } from '../modepaiement';
import { ModepaiementService } from '../modepaiement.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-modepaiement-new',
  templateUrl: './modepaiement-new.component.html',
  styleUrls: ['./modepaiement-new.component.scss']
})
export class ModepaiementNewComponent implements OnInit {
  modepaiement: Modepaiement;
  constructor(public modepaiementSrv: ModepaiementService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.modepaiement = new Modepaiement();
  }

  ngOnInit() {
  }

  saveModepaiement() {
    this.modepaiementSrv.create(this.modepaiement)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Modepaiement créé avec succès');
        this.modepaiement = new Modepaiement();
      }, error => this.modepaiementSrv.httpSrv.handleError(error));
  }

  saveModepaiementAndExit() {
    this.modepaiementSrv.create(this.modepaiement)
      .subscribe((data: any) => {
        this.router.navigate([this.modepaiementSrv.getRoutePrefix(), data.id]);
      }, error => this.modepaiementSrv.httpSrv.handleError(error));
  }

}

