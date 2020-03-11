import { Component, OnInit } from '@angular/core';
import { Anneeacad } from '../anneeacad';
import { AnneeacadService } from '../anneeacad.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-anneeacad-new',
  templateUrl: './anneeacad-new.component.html',
  styleUrls: ['./anneeacad-new.component.scss']
})
export class AnneeacadNewComponent implements OnInit {
  anneeacad: Anneeacad;
  constructor(public anneeacadSrv: AnneeacadService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.anneeacad = new Anneeacad();
  }

  ngOnInit() {
  }

  saveAnneeacad() {
    this.anneeacadSrv.create(this.anneeacad)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Anneeacad créé avec succès');
        this.anneeacad = new Anneeacad();
      }, error => this.anneeacadSrv.httpSrv.handleError(error));
  }

  saveAnneeacadAndExit() {
    this.anneeacadSrv.create(this.anneeacad)
      .subscribe((data: any) => {
        this.router.navigate([this.anneeacadSrv.getRoutePrefix(), data.id]);
      }, error => this.anneeacadSrv.httpSrv.handleError(error));
  }

}

