import { Component, OnInit } from '@angular/core';
import { PaiementFraisEncadrement } from '../paiementfraisencadrement';
import { PaiementFraisEncadrementService } from '../paiementfraisencadrement.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-paiementfraisencadrement-new',
  templateUrl: './paiementfraisencadrement-new.component.html',
  styleUrls: ['./paiementfraisencadrement-new.component.scss']
})
export class PaiementFraisEncadrementNewComponent implements OnInit {
  paiementFraisEncadrement: PaiementFraisEncadrement;
  constructor(public paiementFraisEncadrementSrv: PaiementFraisEncadrementService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.paiementFraisEncadrement = new PaiementFraisEncadrement();
  }

  ngOnInit() {
  }

  savePaiementFraisEncadrement() {
    this.paiementFraisEncadrementSrv.create(this.paiementFraisEncadrement)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('PaiementFraisEncadrement créé avec succès');
        this.paiementFraisEncadrement = new PaiementFraisEncadrement();
      }, error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

  savePaiementFraisEncadrementAndExit() {
    this.paiementFraisEncadrementSrv.create(this.paiementFraisEncadrement)
      .subscribe((data: any) => {
        this.router.navigate([this.paiementFraisEncadrementSrv.getRoutePrefix(), data.id]);
      }, error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

}

