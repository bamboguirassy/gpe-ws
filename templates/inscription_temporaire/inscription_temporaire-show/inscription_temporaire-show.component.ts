import { Component, OnInit } from '@angular/core';
import { InscriptionTemporaire } from '../inscriptiontemporaire';
import { ActivatedRoute, Router } from '@angular/router';
import { InscriptionTemporaireService } from '../inscriptiontemporaire.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-inscriptiontemporaire-show',
  templateUrl: './inscriptiontemporaire-show.component.html',
  styleUrls: ['./inscriptiontemporaire-show.component.scss']
})
export class InscriptionTemporaireShowComponent implements OnInit {

  inscriptionTemporaire: InscriptionTemporaire;
  constructor(public activatedRoute: ActivatedRoute,
    public inscriptionTemporaireSrv: InscriptionTemporaireService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.inscriptionTemporaire = this.activatedRoute.snapshot.data['inscriptionTemporaire'];
  }

  removeInscriptionTemporaire() {
    this.inscriptionTemporaireSrv.remove(this.inscriptionTemporaire)
      .subscribe(data => this.router.navigate([this.inscriptionTemporaireSrv.getRoutePrefix()]),
        error =>  this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.inscriptionTemporaireSrv.findOneById(this.inscriptionTemporaire.id)
    .subscribe((data:any)=>this.inscriptionTemporaire=data,
      error=>this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

}

