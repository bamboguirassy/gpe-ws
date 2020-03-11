import { Component, OnInit } from '@angular/core';
import { Niveau } from '../niveau';
import { ActivatedRoute, Router } from '@angular/router';
import { NiveauService } from '../niveau.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-niveau-show',
  templateUrl: './niveau-show.component.html',
  styleUrls: ['./niveau-show.component.scss']
})
export class NiveauShowComponent implements OnInit {

  niveau: Niveau;
  constructor(public activatedRoute: ActivatedRoute,
    public niveauSrv: NiveauService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.niveau = this.activatedRoute.snapshot.data['niveau'];
  }

  removeNiveau() {
    this.niveauSrv.remove(this.niveau)
      .subscribe(data => this.router.navigate([this.niveauSrv.getRoutePrefix()]),
        error =>  this.niveauSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.niveauSrv.findOneById(this.niveau.id)
    .subscribe((data:any)=>this.niveau=data,
      error=>this.niveauSrv.httpSrv.handleError(error));
  }

}

