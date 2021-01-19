import { Component, OnInit } from '@angular/core';
import { VisiteMedicale } from '../visitemedicale';
import { ActivatedRoute, Router } from '@angular/router';
import { VisiteMedicaleService } from '../visitemedicale.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-visitemedicale-show',
  templateUrl: './visitemedicale-show.component.html',
  styleUrls: ['./visitemedicale-show.component.scss']
})
export class VisiteMedicaleShowComponent implements OnInit {

  visiteMedicale: VisiteMedicale;
  constructor(public activatedRoute: ActivatedRoute,
    public visiteMedicaleSrv: VisiteMedicaleService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.visiteMedicale = this.activatedRoute.snapshot.data['visiteMedicale'];
  }

  removeVisiteMedicale() {
    this.visiteMedicaleSrv.remove(this.visiteMedicale)
      .subscribe(data => this.router.navigate([this.visiteMedicaleSrv.getRoutePrefix()]),
        error =>  this.visiteMedicaleSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.visiteMedicaleSrv.findOneById(this.visiteMedicale.id)
    .subscribe((data:any)=>this.visiteMedicale=data,
      error=>this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

}

