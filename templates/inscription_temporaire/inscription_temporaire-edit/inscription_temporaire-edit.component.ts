
import { Component, OnInit } from '@angular/core';
import { InscriptionTemporaireService } from '../inscriptiontemporaire.service';
import { InscriptionTemporaire } from '../inscriptiontemporaire';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-inscriptiontemporaire-edit',
  templateUrl: './inscriptiontemporaire-edit.component.html',
  styleUrls: ['./inscriptiontemporaire-edit.component.scss']
})
export class InscriptionTemporaireEditComponent implements OnInit {

  inscriptionTemporaire: InscriptionTemporaire;
  constructor(public inscriptionTemporaireSrv: InscriptionTemporaireService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.inscriptionTemporaire = this.activatedRoute.snapshot.data['inscriptionTemporaire'];
  }

  updateInscriptionTemporaire() {
    this.inscriptionTemporaireSrv.update(this.inscriptionTemporaire)
      .subscribe(data => this.location.back(),
        error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

}
