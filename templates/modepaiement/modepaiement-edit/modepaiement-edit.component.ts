
import { Component, OnInit } from '@angular/core';
import { ModepaiementService } from '../modepaiement.service';
import { Modepaiement } from '../modepaiement';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-modepaiement-edit',
  templateUrl: './modepaiement-edit.component.html',
  styleUrls: ['./modepaiement-edit.component.scss']
})
export class ModepaiementEditComponent implements OnInit {

  modepaiement: Modepaiement;
  constructor(public modepaiementSrv: ModepaiementService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.modepaiement = this.activatedRoute.snapshot.data['modepaiement'];
  }

  updateModepaiement() {
    this.modepaiementSrv.update(this.modepaiement)
      .subscribe(data => this.location.back(),
        error => this.modepaiementSrv.httpSrv.handleError(error));
  }

}
