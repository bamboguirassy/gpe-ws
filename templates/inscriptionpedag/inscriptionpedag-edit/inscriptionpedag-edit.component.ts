
import { Component, OnInit } from '@angular/core';
import { InscriptionpedagService } from '../inscriptionpedag.service';
import { Inscriptionpedag } from '../inscriptionpedag';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-inscriptionpedag-edit',
  templateUrl: './inscriptionpedag-edit.component.html',
  styleUrls: ['./inscriptionpedag-edit.component.scss']
})
export class InscriptionpedagEditComponent implements OnInit {

  inscriptionpedag: Inscriptionpedag;
  constructor(public inscriptionpedagSrv: InscriptionpedagService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.inscriptionpedag = this.activatedRoute.snapshot.data['inscriptionpedag'];
  }

  updateInscriptionpedag() {
    this.inscriptionpedagSrv.update(this.inscriptionpedag)
      .subscribe(data => this.location.back(),
        error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

}
