
import { Component, OnInit } from '@angular/core';
import { EtudiantService } from '../etudiant.service';
import { Etudiant } from '../etudiant';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-etudiant-edit',
  templateUrl: './etudiant-edit.component.html',
  styleUrls: ['./etudiant-edit.component.scss']
})
export class EtudiantEditComponent implements OnInit {

  etudiant: Etudiant;
  constructor(public etudiantSrv: EtudiantService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.etudiant = this.activatedRoute.snapshot.data['etudiant'];
  }

  updateEtudiant() {
    this.etudiantSrv.update(this.etudiant)
      .subscribe(data => this.location.back(),
        error => this.etudiantSrv.httpSrv.handleError(error));
  }

}
