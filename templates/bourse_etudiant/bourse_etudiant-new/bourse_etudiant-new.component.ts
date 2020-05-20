import { Component, OnInit } from '@angular/core';
import { BourseEtudiant } from '../bourse_etudiant';
import { BourseEtudiantService } from '../bourse_etudiant.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-bourse_etudiant-new',
  templateUrl: './bourse_etudiant-new.component.html',
  styleUrls: ['./bourse_etudiant-new.component.scss']
})
export class BourseEtudiantNewComponent implements OnInit {
  bourse_etudiant: BourseEtudiant;
  constructor(public bourse_etudiantSrv: BourseEtudiantService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.bourse_etudiant = new BourseEtudiant();
  }

  ngOnInit() {
  }

  saveBourseEtudiant() {
    this.bourse_etudiantSrv.create(this.bourse_etudiant)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('BourseEtudiant créé avec succès');
        this.bourse_etudiant = new BourseEtudiant();
      }, error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

  saveBourseEtudiantAndExit() {
    this.bourse_etudiantSrv.create(this.bourse_etudiant)
      .subscribe((data: any) => {
        this.router.navigate([this.bourse_etudiantSrv.getRoutePrefix(), data.id]);
      }, error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

}

