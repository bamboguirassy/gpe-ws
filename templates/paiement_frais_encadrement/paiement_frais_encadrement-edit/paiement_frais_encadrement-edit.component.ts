
import { Component, OnInit } from '@angular/core';
import { PaiementFraisEncadrementService } from '../paiementfraisencadrement.service';
import { PaiementFraisEncadrement } from '../paiementfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-paiementfraisencadrement-edit',
  templateUrl: './paiementfraisencadrement-edit.component.html',
  styleUrls: ['./paiementfraisencadrement-edit.component.scss']
})
export class PaiementFraisEncadrementEditComponent implements OnInit {

  paiementFraisEncadrement: PaiementFraisEncadrement;
  constructor(public paiementFraisEncadrementSrv: PaiementFraisEncadrementService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.paiementFraisEncadrement = this.activatedRoute.snapshot.data['paiementFraisEncadrement'];
  }

  updatePaiementFraisEncadrement() {
    this.paiementFraisEncadrementSrv.update(this.paiementFraisEncadrement)
      .subscribe(data => this.location.back(),
        error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

}
