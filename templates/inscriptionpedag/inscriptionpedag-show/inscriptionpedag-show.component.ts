import { Component, OnInit } from '@angular/core';
import { Inscriptionpedag } from '../inscriptionpedag';
import { ActivatedRoute, Router } from '@angular/router';
import { InscriptionpedagService } from '../inscriptionpedag.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-inscriptionpedag-show',
  templateUrl: './inscriptionpedag-show.component.html',
  styleUrls: ['./inscriptionpedag-show.component.scss']
})
export class InscriptionpedagShowComponent implements OnInit {

  inscriptionpedag: Inscriptionpedag;
  constructor(public activatedRoute: ActivatedRoute,
    public inscriptionpedagSrv: InscriptionpedagService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.inscriptionpedag = this.activatedRoute.snapshot.data['inscriptionpedag'];
  }

  removeInscriptionpedag() {
    this.inscriptionpedagSrv.remove(this.inscriptionpedag)
      .subscribe(data => this.router.navigate([this.inscriptionpedagSrv.getRoutePrefix()]),
        error =>  this.inscriptionpedagSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.inscriptionpedagSrv.findOneById(this.inscriptionpedag.id)
    .subscribe((data:any)=>this.inscriptionpedag=data,
      error=>this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

}

