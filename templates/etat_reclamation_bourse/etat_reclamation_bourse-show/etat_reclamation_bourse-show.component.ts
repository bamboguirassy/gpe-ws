import { Component, OnInit } from '@angular/core';
import { EtatReclamationBourse } from '../etat_reclamation_bourse';
import { ActivatedRoute, Router } from '@angular/router';
import { EtatReclamationBourseService } from '../etat_reclamation_bourse.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-etat_reclamation_bourse-show',
  templateUrl: './etat_reclamation_bourse-show.component.html',
  styleUrls: ['./etat_reclamation_bourse-show.component.scss']
})
export class EtatReclamationBourseShowComponent implements OnInit {

  etat_reclamation_bourse: EtatReclamationBourse;
  constructor(public activatedRoute: ActivatedRoute,
    public etat_reclamation_bourseSrv: EtatReclamationBourseService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.etat_reclamation_bourse = this.activatedRoute.snapshot.data['etat_reclamation_bourse'];
  }

  removeEtatReclamationBourse() {
    this.etat_reclamation_bourseSrv.remove(this.etat_reclamation_bourse)
      .subscribe(data => this.router.navigate([this.etat_reclamation_bourseSrv.getRoutePrefix()]),
        error =>  this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.etat_reclamation_bourseSrv.findOneById(this.etat_reclamation_bourse.id)
    .subscribe((data:any)=>this.etat_reclamation_bourse=data,
      error=>this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

}

