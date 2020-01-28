
import { Component, OnInit } from '@angular/core';
import { SpecialiteService } from '../specialite.service';
import { Specialite } from '../specialite';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-specialite-edit',
  templateUrl: './specialite-edit.component.html',
  styleUrls: ['./specialite-edit.component.scss']
})
export class SpecialiteEditComponent implements OnInit {

  specialite: Specialite;
  constructor(public specialiteSrv: SpecialiteService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.specialite = this.activatedRoute.snapshot.data['specialite'];
  }

  updateSpecialite() {
    this.specialiteSrv.update(this.specialite)
      .subscribe(data => this.location.back(),
        error => this.specialiteSrv.httpSrv.handleError(error));
  }

}
