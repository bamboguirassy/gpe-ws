import { Component, OnInit } from '@angular/core';
import { InscriptionTemporaire } from '../inscriptiontemporaire';
import { InscriptionTemporaireService } from '../inscriptiontemporaire.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-inscriptiontemporaire-new',
  templateUrl: './inscriptiontemporaire-new.component.html',
  styleUrls: ['./inscriptiontemporaire-new.component.scss']
})
export class InscriptionTemporaireNewComponent implements OnInit {
  inscriptionTemporaire: InscriptionTemporaire;
  constructor(public inscriptionTemporaireSrv: InscriptionTemporaireService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.inscriptionTemporaire = new InscriptionTemporaire();
  }

  ngOnInit() {
  }

  saveInscriptionTemporaire() {
    this.inscriptionTemporaireSrv.create(this.inscriptionTemporaire)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('InscriptionTemporaire créé avec succès');
        this.inscriptionTemporaire = new InscriptionTemporaire();
      }, error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

  saveInscriptionTemporaireAndExit() {
    this.inscriptionTemporaireSrv.create(this.inscriptionTemporaire)
      .subscribe((data: any) => {
        this.router.navigate([this.inscriptionTemporaireSrv.getRoutePrefix(), data.id]);
      }, error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

}

