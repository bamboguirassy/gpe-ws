import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatDemande } from '../historique_etat_demande';
import { ActivatedRoute, Router } from '@angular/router';
import { HistoriqueEtatDemandeService } from '../historique_etat_demande.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-historique_etat_demande-show',
  templateUrl: './historique_etat_demande-show.component.html',
  styleUrls: ['./historique_etat_demande-show.component.scss']
})
export class HistoriqueEtatDemandeShowComponent implements OnInit {

  historique_etat_demande: HistoriqueEtatDemande;
  constructor(public activatedRoute: ActivatedRoute,
    public historique_etat_demandeSrv: HistoriqueEtatDemandeService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.historique_etat_demande = this.activatedRoute.snapshot.data['historique_etat_demande'];
  }

  removeHistoriqueEtatDemande() {
    this.historique_etat_demandeSrv.remove(this.historique_etat_demande)
      .subscribe(data => this.router.navigate([this.historique_etat_demandeSrv.getRoutePrefix()]),
        error =>  this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.historique_etat_demandeSrv.findOneById(this.historique_etat_demande.id)
    .subscribe((data:any)=>this.historique_etat_demande=data,
      error=>this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

}

