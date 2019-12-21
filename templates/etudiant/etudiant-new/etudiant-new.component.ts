import { Component, OnInit } from '@angular/core';
import { Etudiant } from '../etudiant';
import { EtudiantService } from '../etudiant.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-etudiant-new',
  templateUrl: './etudiant-new.component.html',
  styleUrls: ['./etudiant-new.component.scss']
})
export class EtudiantNewComponent implements OnInit {
  etudiant: Etudiant;
  constructor(public etudiantSrv: EtudiantService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.etudiant = new Etudiant();
  }

  ngOnInit() {
  }

  saveEtudiant() {
    this.etudiantSrv.create(this.etudiant)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Etudiant créé avec succès');
        this.etudiant = new Etudiant();
      }, error => this.etudiantSrv.httpSrv.handleError(error));
  }

  saveEtudiantAndExit() {
    this.etudiantSrv.create(this.etudiant)
      .subscribe((data: any) => {
        this.router.navigate([this.etudiantSrv.getRoutePrefix(), data.id]);
      }, error => this.etudiantSrv.httpSrv.handleError(error));
  }

}

