import { Component, OnInit } from '@angular/core';
import { Preinscription } from '../preinscription';
import { ActivatedRoute, Router } from '@angular/router';
import { PreinscriptionService } from '../preinscription.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-preinscription-show',
  templateUrl: './preinscription-show.component.html',
  styleUrls: ['./preinscription-show.component.scss']
})
export class PreinscriptionShowComponent implements OnInit {

  preinscription: Preinscription;
  constructor(public activatedRoute: ActivatedRoute,
    public preinscriptionSrv: PreinscriptionService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.preinscription = this.activatedRoute.snapshot.data['preinscription'];
  }

  removePreinscription() {
    this.preinscriptionSrv.remove(this.preinscription)
      .subscribe(data => this.router.navigate([this.preinscriptionSrv.getRoutePrefix()]),
        error =>  this.preinscriptionSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.preinscriptionSrv.findOneById(this.preinscription.id)
    .subscribe((data:any)=>this.preinscription=data,
      error=>this.preinscriptionSrv.httpSrv.handleError(error));
  }

}

