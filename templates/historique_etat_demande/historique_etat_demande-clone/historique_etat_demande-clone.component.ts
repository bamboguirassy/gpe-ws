
import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatDemandeService } from '../historique_etat_demande.service';
import { Location } from '@angular/common';
import { HistoriqueEtatDemande } from '../historique_etat_demande';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-historique_etat_demande-clone',
  templateUrl: './historique_etat_demande-clone.component.html',
  styleUrls: ['./historique_etat_demande-clone.component.scss']
})
export class HistoriqueEtatDemandeCloneComponent implements OnInit {
  historique_etat_demande: HistoriqueEtatDemande;
  original: HistoriqueEtatDemande;
  constructor(public historique_etat_demandeSrv: HistoriqueEtatDemandeService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['historique_etat_demande'];
    this.historique_etat_demande = Object.assign({}, this.original);
    this.historique_etat_demande.id = null;
  }

  cloneHistoriqueEtatDemande() {
    console.log(this.historique_etat_demande);
    this.historique_etat_demandeSrv.clone(this.original, this.historique_etat_demande)
      .subscribe((data: any) => {
        this.router.navigate([this.historique_etat_demandeSrv.getRoutePrefix(), data.id]);
      }, error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

}
