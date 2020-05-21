
import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatDemandeService } from '../historique_etat_demande.service';
import { HistoriqueEtatDemande } from '../historique_etat_demande';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-historique_etat_demande-edit',
  templateUrl: './historique_etat_demande-edit.component.html',
  styleUrls: ['./historique_etat_demande-edit.component.scss']
})
export class HistoriqueEtatDemandeEditComponent implements OnInit {

  historique_etat_demande: HistoriqueEtatDemande;
  constructor(public historique_etat_demandeSrv: HistoriqueEtatDemandeService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.historique_etat_demande = this.activatedRoute.snapshot.data['historique_etat_demande'];
  }

  updateHistoriqueEtatDemande() {
    this.historique_etat_demandeSrv.update(this.historique_etat_demande)
      .subscribe(data => this.location.back(),
        error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

}
