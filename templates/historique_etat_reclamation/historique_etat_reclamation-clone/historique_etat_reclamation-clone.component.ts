
import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatReclamationService } from '../historique_etat_reclamation.service';
import { Location } from '@angular/common';
import { HistoriqueEtatReclamation } from '../historique_etat_reclamation';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-historique_etat_reclamation-clone',
  templateUrl: './historique_etat_reclamation-clone.component.html',
  styleUrls: ['./historique_etat_reclamation-clone.component.scss']
})
export class HistoriqueEtatReclamationCloneComponent implements OnInit {
  historique_etat_reclamation: HistoriqueEtatReclamation;
  original: HistoriqueEtatReclamation;
  constructor(public historique_etat_reclamationSrv: HistoriqueEtatReclamationService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['historique_etat_reclamation'];
    this.historique_etat_reclamation = Object.assign({}, this.original);
    this.historique_etat_reclamation.id = null;
  }

  cloneHistoriqueEtatReclamation() {
    console.log(this.historique_etat_reclamation);
    this.historique_etat_reclamationSrv.clone(this.original, this.historique_etat_reclamation)
      .subscribe((data: any) => {
        this.router.navigate([this.historique_etat_reclamationSrv.getRoutePrefix(), data.id]);
      }, error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

}
