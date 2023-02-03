import { Component, OnInit } from '@angular/core';
import { PaiementFraisEncadrement } from '../paiementfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';
import { PaiementFraisEncadrementService } from '../paiementfraisencadrement.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-paiementfraisencadrement-show',
  templateUrl: './paiementfraisencadrement-show.component.html',
  styleUrls: ['./paiementfraisencadrement-show.component.scss']
})
export class PaiementFraisEncadrementShowComponent implements OnInit {

  paiementFraisEncadrement: PaiementFraisEncadrement;
  constructor(public activatedRoute: ActivatedRoute,
    public paiementFraisEncadrementSrv: PaiementFraisEncadrementService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.paiementFraisEncadrement = this.activatedRoute.snapshot.data['paiementFraisEncadrement'];
  }

  removePaiementFraisEncadrement() {
    this.paiementFraisEncadrementSrv.remove(this.paiementFraisEncadrement)
      .subscribe(data => this.router.navigate([this.paiementFraisEncadrementSrv.getRoutePrefix()]),
        error =>  this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.paiementFraisEncadrementSrv.findOneById(this.paiementFraisEncadrement.id)
    .subscribe((data:any)=>this.paiementFraisEncadrement=data,
      error=>this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

}

