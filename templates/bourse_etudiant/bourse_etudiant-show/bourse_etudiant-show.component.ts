import { Component, OnInit } from '@angular/core';
import { BourseEtudiant } from '../bourse_etudiant';
import { ActivatedRoute, Router } from '@angular/router';
import { BourseEtudiantService } from '../bourse_etudiant.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-bourse_etudiant-show',
  templateUrl: './bourse_etudiant-show.component.html',
  styleUrls: ['./bourse_etudiant-show.component.scss']
})
export class BourseEtudiantShowComponent implements OnInit {

  bourse_etudiant: BourseEtudiant;
  constructor(public activatedRoute: ActivatedRoute,
    public bourse_etudiantSrv: BourseEtudiantService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.bourse_etudiant = this.activatedRoute.snapshot.data['bourse_etudiant'];
  }

  removeBourseEtudiant() {
    this.bourse_etudiantSrv.remove(this.bourse_etudiant)
      .subscribe(data => this.router.navigate([this.bourse_etudiantSrv.getRoutePrefix()]),
        error =>  this.bourse_etudiantSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.bourse_etudiantSrv.findOneById(this.bourse_etudiant.id)
    .subscribe((data:any)=>this.bourse_etudiant=data,
      error=>this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

}

