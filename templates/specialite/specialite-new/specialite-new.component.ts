import { Component, OnInit } from '@angular/core';
import { Specialite } from '../specialite';
import { SpecialiteService } from '../specialite.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-specialite-new',
  templateUrl: './specialite-new.component.html',
  styleUrls: ['./specialite-new.component.scss']
})
export class SpecialiteNewComponent implements OnInit {
  specialite: Specialite;
  constructor(public specialiteSrv: SpecialiteService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.specialite = new Specialite();
  }

  ngOnInit() {
  }

  saveSpecialite() {
    this.specialiteSrv.create(this.specialite)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Specialite créé avec succès');
        this.specialite = new Specialite();
      }, error => this.specialiteSrv.httpSrv.handleError(error));
  }

  saveSpecialiteAndExit() {
    this.specialiteSrv.create(this.specialite)
      .subscribe((data: any) => {
        this.router.navigate([this.specialiteSrv.getRoutePrefix(), data.id]);
      }, error => this.specialiteSrv.httpSrv.handleError(error));
  }

}

