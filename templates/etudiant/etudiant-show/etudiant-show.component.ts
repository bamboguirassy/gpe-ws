import { Component, OnInit } from '@angular/core';
import { Etudiant } from '../etudiant';
import { ActivatedRoute, Router } from '@angular/router';
import { EtudiantService } from '../etudiant.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-etudiant-show',
  templateUrl: './etudiant-show.component.html',
  styleUrls: ['./etudiant-show.component.scss']
})
export class EtudiantShowComponent implements OnInit {

  etudiant: Etudiant;
  constructor(public activatedRoute: ActivatedRoute,
    public etudiantSrv: EtudiantService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.etudiant = this.activatedRoute.snapshot.data['etudiant'];
  }

  removeEtudiant() {
    this.etudiantSrv.remove(this.etudiant)
      .subscribe(data => this.router.navigate([this.etudiantSrv.getRoutePrefix()]),
        error =>  this.etudiantSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.etudiantSrv.findOneById(this.etudiant.id)
    .subscribe((data:any)=>this.etudiant=data,
      error=>this.etudiantSrv.httpSrv.handleError(error));
  }

}

