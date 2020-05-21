import { Component, OnInit } from '@angular/core';
import { ReclamationBourse } from '../reclamation_bourse';
import { ActivatedRoute, Router } from '@angular/router';
import { ReclamationBourseService } from '../reclamation_bourse.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-reclamation_bourse-show',
  templateUrl: './reclamation_bourse-show.component.html',
  styleUrls: ['./reclamation_bourse-show.component.scss']
})
export class ReclamationBourseShowComponent implements OnInit {

  reclamation_bourse: ReclamationBourse;
  constructor(public activatedRoute: ActivatedRoute,
    public reclamation_bourseSrv: ReclamationBourseService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.reclamation_bourse = this.activatedRoute.snapshot.data['reclamation_bourse'];
  }

  removeReclamationBourse() {
    this.reclamation_bourseSrv.remove(this.reclamation_bourse)
      .subscribe(data => this.router.navigate([this.reclamation_bourseSrv.getRoutePrefix()]),
        error =>  this.reclamation_bourseSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.reclamation_bourseSrv.findOneById(this.reclamation_bourse.id)
    .subscribe((data:any)=>this.reclamation_bourse=data,
      error=>this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

}

