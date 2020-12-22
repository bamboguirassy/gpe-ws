import { Component, OnInit } from '@angular/core';
import { Modepaiement } from '../modepaiement';
import { ActivatedRoute, Router } from '@angular/router';
import { ModepaiementService } from '../modepaiement.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-modepaiement-show',
  templateUrl: './modepaiement-show.component.html',
  styleUrls: ['./modepaiement-show.component.scss']
})
export class ModepaiementShowComponent implements OnInit {

  modepaiement: Modepaiement;
  constructor(public activatedRoute: ActivatedRoute,
    public modepaiementSrv: ModepaiementService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.modepaiement = this.activatedRoute.snapshot.data['modepaiement'];
  }

  removeModepaiement() {
    this.modepaiementSrv.remove(this.modepaiement)
      .subscribe(data => this.router.navigate([this.modepaiementSrv.getRoutePrefix()]),
        error =>  this.modepaiementSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.modepaiementSrv.findOneById(this.modepaiement.id)
    .subscribe((data:any)=>this.modepaiement=data,
      error=>this.modepaiementSrv.httpSrv.handleError(error));
  }

}

