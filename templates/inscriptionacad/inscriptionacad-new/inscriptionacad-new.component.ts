import { Component, OnInit } from '@angular/core';
import { Inscriptionacad } from '../inscriptionacad';
import { InscriptionacadService } from '../inscriptionacad.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-inscriptionacad-new',
  templateUrl: './inscriptionacad-new.component.html',
  styleUrls: ['./inscriptionacad-new.component.scss']
})
export class InscriptionacadNewComponent implements OnInit {
  inscriptionacad: Inscriptionacad;
  constructor(public inscriptionacadSrv: InscriptionacadService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.inscriptionacad = new Inscriptionacad();
  }

  ngOnInit() {
  }

  saveInscriptionacad() {
    this.inscriptionacadSrv.create(this.inscriptionacad)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Inscriptionacad créé avec succès');
        this.inscriptionacad = new Inscriptionacad();
      }, error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

  saveInscriptionacadAndExit() {
    this.inscriptionacadSrv.create(this.inscriptionacad)
      .subscribe((data: any) => {
        this.router.navigate([this.inscriptionacadSrv.getRoutePrefix(), data.id]);
      }, error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

}

