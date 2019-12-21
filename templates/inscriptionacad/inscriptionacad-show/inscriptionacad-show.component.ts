import { Component, OnInit } from '@angular/core';
import { Inscriptionacad } from '../inscriptionacad';
import { ActivatedRoute, Router } from '@angular/router';
import { InscriptionacadService } from '../inscriptionacad.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-inscriptionacad-show',
  templateUrl: './inscriptionacad-show.component.html',
  styleUrls: ['./inscriptionacad-show.component.scss']
})
export class InscriptionacadShowComponent implements OnInit {

  inscriptionacad: Inscriptionacad;
  constructor(public activatedRoute: ActivatedRoute,
    public inscriptionacadSrv: InscriptionacadService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.inscriptionacad = this.activatedRoute.snapshot.data['inscriptionacad'];
  }

  removeInscriptionacad() {
    this.inscriptionacadSrv.remove(this.inscriptionacad)
      .subscribe(data => this.router.navigate([this.inscriptionacadSrv.getRoutePrefix()]),
        error =>  this.inscriptionacadSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.inscriptionacadSrv.findOneById(this.inscriptionacad.id)
    .subscribe((data:any)=>this.inscriptionacad=data,
      error=>this.inscriptionacadSrv.httpSrv.handleError(error));
  }

}

