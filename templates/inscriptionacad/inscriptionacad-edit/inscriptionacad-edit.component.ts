
import { Component, OnInit } from '@angular/core';
import { InscriptionacadService } from '../inscriptionacad.service';
import { Inscriptionacad } from '../inscriptionacad';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-inscriptionacad-edit',
  templateUrl: './inscriptionacad-edit.component.html',
  styleUrls: ['./inscriptionacad-edit.component.scss']
})
export class InscriptionacadEditComponent implements OnInit {

  inscriptionacad: Inscriptionacad;
  constructor(public inscriptionacadSrv: InscriptionacadService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.inscriptionacad = this.activatedRoute.snapshot.data['inscriptionacad'];
  }

  updateInscriptionacad() {
    this.inscriptionacadSrv.update(this.inscriptionacad)
      .subscribe(data => this.location.back(),
        error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

}
