import { Component, OnInit } from '@angular/core';
import { Filiere } from '../filiere';
import { FiliereService } from '../filiere.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-filiere-new',
  templateUrl: './filiere-new.component.html',
  styleUrls: ['./filiere-new.component.scss']
})
export class FiliereNewComponent implements OnInit {
  filiere: Filiere;
  constructor(public filiereSrv: FiliereService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.filiere = new Filiere();
  }

  ngOnInit() {
  }

  saveFiliere() {
    this.filiereSrv.create(this.filiere)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Filiere créé avec succès');
        this.filiere = new Filiere();
      }, error => this.filiereSrv.httpSrv.handleError(error));
  }

  saveFiliereAndExit() {
    this.filiereSrv.create(this.filiere)
      .subscribe((data: any) => {
        this.router.navigate([this.filiereSrv.getRoutePrefix(), data.id]);
      }, error => this.filiereSrv.httpSrv.handleError(error));
  }

}

