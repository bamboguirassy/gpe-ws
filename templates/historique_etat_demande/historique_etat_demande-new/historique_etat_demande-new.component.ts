import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatDemande } from '../historique_etat_demande';
import { HistoriqueEtatDemandeService } from '../historique_etat_demande.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-historique_etat_demande-new',
  templateUrl: './historique_etat_demande-new.component.html',
  styleUrls: ['./historique_etat_demande-new.component.scss']
})
export class HistoriqueEtatDemandeNewComponent implements OnInit {
  historique_etat_demande: HistoriqueEtatDemande;
  constructor(public historique_etat_demandeSrv: HistoriqueEtatDemandeService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.historique_etat_demande = new HistoriqueEtatDemande();
  }

  ngOnInit() {
  }

  saveHistoriqueEtatDemande() {
    this.historique_etat_demandeSrv.create(this.historique_etat_demande)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('HistoriqueEtatDemande créé avec succès');
        this.historique_etat_demande = new HistoriqueEtatDemande();
      }, error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

  saveHistoriqueEtatDemandeAndExit() {
    this.historique_etat_demandeSrv.create(this.historique_etat_demande)
      .subscribe((data: any) => {
        this.router.navigate([this.historique_etat_demandeSrv.getRoutePrefix(), data.id]);
      }, error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

}

