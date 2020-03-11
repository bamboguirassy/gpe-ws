import { Component, OnInit } from '@angular/core';
import { Anneeacad } from '../anneeacad';
import { ActivatedRoute, Router } from '@angular/router';
import { AnneeacadService } from '../anneeacad.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-anneeacad-show',
  templateUrl: './anneeacad-show.component.html',
  styleUrls: ['./anneeacad-show.component.scss']
})
export class AnneeacadShowComponent implements OnInit {

  anneeacad: Anneeacad;
  constructor(public activatedRoute: ActivatedRoute,
    public anneeacadSrv: AnneeacadService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.anneeacad = this.activatedRoute.snapshot.data['anneeacad'];
  }

  removeAnneeacad() {
    this.anneeacadSrv.remove(this.anneeacad)
      .subscribe(data => this.router.navigate([this.anneeacadSrv.getRoutePrefix()]),
        error =>  this.anneeacadSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.anneeacadSrv.findOneById(this.anneeacad.id)
    .subscribe((data:any)=>this.anneeacad=data,
      error=>this.anneeacadSrv.httpSrv.handleError(error));
  }

}

