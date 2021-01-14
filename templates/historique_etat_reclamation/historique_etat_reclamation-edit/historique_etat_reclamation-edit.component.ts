
import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatReclamationService } from '../historique_etat_reclamation.service';
import { HistoriqueEtatReclamation } from '../historique_etat_reclamation';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-historique_etat_reclamation-edit',
  templateUrl: './historique_etat_reclamation-edit.component.html',
  styleUrls: ['./historique_etat_reclamation-edit.component.scss']
})
export class HistoriqueEtatReclamationEditComponent implements OnInit {

  historique_etat_reclamation: HistoriqueEtatReclamation;
  constructor(public historique_etat_reclamationSrv: HistoriqueEtatReclamationService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.historique_etat_reclamation = this.activatedRoute.snapshot.data['historique_etat_reclamation'];
  }

  updateHistoriqueEtatReclamation() {
    this.historique_etat_reclamationSrv.update(this.historique_etat_reclamation)
      .subscribe(data => this.location.back(),
        error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

}
