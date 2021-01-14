
import { Component, OnInit } from '@angular/core';
import { EtatReclamationBourseService } from '../etat_reclamation_bourse.service';
import { EtatReclamationBourse } from '../etat_reclamation_bourse';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-etat_reclamation_bourse-edit',
  templateUrl: './etat_reclamation_bourse-edit.component.html',
  styleUrls: ['./etat_reclamation_bourse-edit.component.scss']
})
export class EtatReclamationBourseEditComponent implements OnInit {

  etat_reclamation_bourse: EtatReclamationBourse;
  constructor(public etat_reclamation_bourseSrv: EtatReclamationBourseService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.etat_reclamation_bourse = this.activatedRoute.snapshot.data['etat_reclamation_bourse'];
  }

  updateEtatReclamationBourse() {
    this.etat_reclamation_bourseSrv.update(this.etat_reclamation_bourse)
      .subscribe(data => this.location.back(),
        error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

}
