import { Component, OnInit } from '@angular/core';
import { Filiere } from '../filiere';
import { ActivatedRoute, Router } from '@angular/router';
import { FiliereService } from '../filiere.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-filiere-show',
  templateUrl: './filiere-show.component.html',
  styleUrls: ['./filiere-show.component.scss']
})
export class FiliereShowComponent implements OnInit {

  filiere: Filiere;
  constructor(public activatedRoute: ActivatedRoute,
    public filiereSrv: FiliereService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.filiere = this.activatedRoute.snapshot.data['filiere'];
  }

  removeFiliere() {
    this.filiereSrv.remove(this.filiere)
      .subscribe(data => this.router.navigate([this.filiereSrv.getRoutePrefix()]),
        error =>  this.filiereSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.filiereSrv.findOneById(this.filiere.id)
    .subscribe((data:any)=>this.filiere=data,
      error=>this.filiereSrv.httpSrv.handleError(error));
  }

}

