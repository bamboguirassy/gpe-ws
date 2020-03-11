
import { Component, OnInit } from '@angular/core';
import { NiveauService } from '../niveau.service';
import { Niveau } from '../niveau';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-niveau-edit',
  templateUrl: './niveau-edit.component.html',
  styleUrls: ['./niveau-edit.component.scss']
})
export class NiveauEditComponent implements OnInit {

  niveau: Niveau;
  constructor(public niveauSrv: NiveauService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.niveau = this.activatedRoute.snapshot.data['niveau'];
  }

  updateNiveau() {
    this.niveauSrv.update(this.niveau)
      .subscribe(data => this.location.back(),
        error => this.niveauSrv.httpSrv.handleError(error));
  }

}
