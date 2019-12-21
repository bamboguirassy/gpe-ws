
import { Component, OnInit } from '@angular/core';
import { PreinscriptionService } from '../preinscription.service';
import { Preinscription } from '../preinscription';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-preinscription-edit',
  templateUrl: './preinscription-edit.component.html',
  styleUrls: ['./preinscription-edit.component.scss']
})
export class PreinscriptionEditComponent implements OnInit {

  preinscription: Preinscription;
  constructor(public preinscriptionSrv: PreinscriptionService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.preinscription = this.activatedRoute.snapshot.data['preinscription'];
  }

  updatePreinscription() {
    this.preinscriptionSrv.update(this.preinscription)
      .subscribe(data => this.location.back(),
        error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

}
