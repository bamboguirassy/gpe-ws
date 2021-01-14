import { Component, OnInit } from '@angular/core';
import { EtatReclamationBourse } from '../etat_reclamation_bourse';
import { EtatReclamationBourseService } from '../etat_reclamation_bourse.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-etat_reclamation_bourse-new',
  templateUrl: './etat_reclamation_bourse-new.component.html',
  styleUrls: ['./etat_reclamation_bourse-new.component.scss']
})
export class EtatReclamationBourseNewComponent implements OnInit {
  etat_reclamation_bourse: EtatReclamationBourse;
  constructor(public etat_reclamation_bourseSrv: EtatReclamationBourseService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.etat_reclamation_bourse = new EtatReclamationBourse();
  }

  ngOnInit() {
  }

  saveEtatReclamationBourse() {
    this.etat_reclamation_bourseSrv.create(this.etat_reclamation_bourse)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('EtatReclamationBourse créé avec succès');
        this.etat_reclamation_bourse = new EtatReclamationBourse();
      }, error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

  saveEtatReclamationBourseAndExit() {
    this.etat_reclamation_bourseSrv.create(this.etat_reclamation_bourse)
      .subscribe((data: any) => {
        this.router.navigate([this.etat_reclamation_bourseSrv.getRoutePrefix(), data.id]);
      }, error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

}

