
import { Component, OnInit } from '@angular/core';
import { BourseEtudiantService } from '../bourse_etudiant.service';
import { BourseEtudiant } from '../bourse_etudiant';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-bourse_etudiant-edit',
  templateUrl: './bourse_etudiant-edit.component.html',
  styleUrls: ['./bourse_etudiant-edit.component.scss']
})
export class BourseEtudiantEditComponent implements OnInit {

  bourse_etudiant: BourseEtudiant;
  constructor(public bourse_etudiantSrv: BourseEtudiantService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.bourse_etudiant = this.activatedRoute.snapshot.data['bourse_etudiant'];
  }

  updateBourseEtudiant() {
    this.bourse_etudiantSrv.update(this.bourse_etudiant)
      .subscribe(data => this.location.back(),
        error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

}
