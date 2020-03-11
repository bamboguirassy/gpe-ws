
import { Component, OnInit } from '@angular/core';
import { FiliereService } from '../filiere.service';
import { Filiere } from '../filiere';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-filiere-edit',
  templateUrl: './filiere-edit.component.html',
  styleUrls: ['./filiere-edit.component.scss']
})
export class FiliereEditComponent implements OnInit {

  filiere: Filiere;
  constructor(public filiereSrv: FiliereService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.filiere = this.activatedRoute.snapshot.data['filiere'];
  }

  updateFiliere() {
    this.filiereSrv.update(this.filiere)
      .subscribe(data => this.location.back(),
        error => this.filiereSrv.httpSrv.handleError(error));
  }

}
