import { Component, OnInit } from '@angular/core';
import { Specialite } from '../specialite';
import { ActivatedRoute, Router } from '@angular/router';
import { SpecialiteService } from '../specialite.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-specialite-show',
  templateUrl: './specialite-show.component.html',
  styleUrls: ['./specialite-show.component.scss']
})
export class SpecialiteShowComponent implements OnInit {

  specialite: Specialite;
  constructor(public activatedRoute: ActivatedRoute,
    public specialiteSrv: SpecialiteService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.specialite = this.activatedRoute.snapshot.data['specialite'];
  }

  removeSpecialite() {
    this.specialiteSrv.remove(this.specialite)
      .subscribe(data => this.router.navigate([this.specialiteSrv.getRoutePrefix()]),
        error =>  this.specialiteSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.specialiteSrv.findOneById(this.specialite.id)
    .subscribe((data:any)=>this.specialite=data,
      error=>this.specialiteSrv.httpSrv.handleError(error));
  }

}

