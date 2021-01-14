import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatReclamation } from '../historique_etat_reclamation';
import { HistoriqueEtatReclamationService } from '../historique_etat_reclamation.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-historique_etat_reclamation-new',
  templateUrl: './historique_etat_reclamation-new.component.html',
  styleUrls: ['./historique_etat_reclamation-new.component.scss']
})
export class HistoriqueEtatReclamationNewComponent implements OnInit {
  historique_etat_reclamation: HistoriqueEtatReclamation;
  constructor(public historique_etat_reclamationSrv: HistoriqueEtatReclamationService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.historique_etat_reclamation = new HistoriqueEtatReclamation();
  }

  ngOnInit() {
  }

  saveHistoriqueEtatReclamation() {
    this.historique_etat_reclamationSrv.create(this.historique_etat_reclamation)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('HistoriqueEtatReclamation créé avec succès');
        this.historique_etat_reclamation = new HistoriqueEtatReclamation();
      }, error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

  saveHistoriqueEtatReclamationAndExit() {
    this.historique_etat_reclamationSrv.create(this.historique_etat_reclamation)
      .subscribe((data: any) => {
        this.router.navigate([this.historique_etat_reclamationSrv.getRoutePrefix(), data.id]);
      }, error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

}

