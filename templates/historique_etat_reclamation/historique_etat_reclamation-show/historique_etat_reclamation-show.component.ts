import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatReclamation } from '../historique_etat_reclamation';
import { ActivatedRoute, Router } from '@angular/router';
import { HistoriqueEtatReclamationService } from '../historique_etat_reclamation.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-historique_etat_reclamation-show',
  templateUrl: './historique_etat_reclamation-show.component.html',
  styleUrls: ['./historique_etat_reclamation-show.component.scss']
})
export class HistoriqueEtatReclamationShowComponent implements OnInit {

  historique_etat_reclamation: HistoriqueEtatReclamation;
  constructor(public activatedRoute: ActivatedRoute,
    public historique_etat_reclamationSrv: HistoriqueEtatReclamationService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.historique_etat_reclamation = this.activatedRoute.snapshot.data['historique_etat_reclamation'];
  }

  removeHistoriqueEtatReclamation() {
    this.historique_etat_reclamationSrv.remove(this.historique_etat_reclamation)
      .subscribe(data => this.router.navigate([this.historique_etat_reclamationSrv.getRoutePrefix()]),
        error =>  this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.historique_etat_reclamationSrv.findOneById(this.historique_etat_reclamation.id)
    .subscribe((data:any)=>this.historique_etat_reclamation=data,
      error=>this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

}

