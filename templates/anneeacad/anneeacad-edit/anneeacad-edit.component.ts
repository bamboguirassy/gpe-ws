
import { Component, OnInit } from '@angular/core';
import { AnneeacadService } from '../anneeacad.service';
import { Anneeacad } from '../anneeacad';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-anneeacad-edit',
  templateUrl: './anneeacad-edit.component.html',
  styleUrls: ['./anneeacad-edit.component.scss']
})
export class AnneeacadEditComponent implements OnInit {

  anneeacad: Anneeacad;
  constructor(public anneeacadSrv: AnneeacadService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.anneeacad = this.activatedRoute.snapshot.data['anneeacad'];
  }

  updateAnneeacad() {
    this.anneeacadSrv.update(this.anneeacad)
      .subscribe(data => this.location.back(),
        error => this.anneeacadSrv.httpSrv.handleError(error));
  }

}
