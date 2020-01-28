
import { Component, OnInit } from '@angular/core';
import { RegimeinscriptionService } from '../regimeinscription.service';
import { Regimeinscription } from '../regimeinscription';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-regimeinscription-edit',
  templateUrl: './regimeinscription-edit.component.html',
  styleUrls: ['./regimeinscription-edit.component.scss']
})
export class RegimeinscriptionEditComponent implements OnInit {

  regimeinscription: Regimeinscription;
  constructor(public regimeinscriptionSrv: RegimeinscriptionService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.regimeinscription = this.activatedRoute.snapshot.data['regimeinscription'];
  }

  updateRegimeinscription() {
    this.regimeinscriptionSrv.update(this.regimeinscription)
      .subscribe(data => this.location.back(),
        error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

}
