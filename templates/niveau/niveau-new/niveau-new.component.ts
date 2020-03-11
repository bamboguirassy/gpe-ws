import { Component, OnInit } from '@angular/core';
import { Niveau } from '../niveau';
import { NiveauService } from '../niveau.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-niveau-new',
  templateUrl: './niveau-new.component.html',
  styleUrls: ['./niveau-new.component.scss']
})
export class NiveauNewComponent implements OnInit {
  niveau: Niveau;
  constructor(public niveauSrv: NiveauService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.niveau = new Niveau();
  }

  ngOnInit() {
  }

  saveNiveau() {
    this.niveauSrv.create(this.niveau)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Niveau créé avec succès');
        this.niveau = new Niveau();
      }, error => this.niveauSrv.httpSrv.handleError(error));
  }

  saveNiveauAndExit() {
    this.niveauSrv.create(this.niveau)
      .subscribe((data: any) => {
        this.router.navigate([this.niveauSrv.getRoutePrefix(), data.id]);
      }, error => this.niveauSrv.httpSrv.handleError(error));
  }

}

