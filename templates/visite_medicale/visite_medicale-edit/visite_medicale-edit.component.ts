
import { Component, OnInit } from '@angular/core';
import { VisiteMedicaleService } from '../visitemedicale.service';
import { VisiteMedicale } from '../visitemedicale';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-visitemedicale-edit',
  templateUrl: './visitemedicale-edit.component.html',
  styleUrls: ['./visitemedicale-edit.component.scss']
})
export class VisiteMedicaleEditComponent implements OnInit {

  visiteMedicale: VisiteMedicale;
  constructor(public visiteMedicaleSrv: VisiteMedicaleService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.visiteMedicale = this.activatedRoute.snapshot.data['visiteMedicale'];
  }

  updateVisiteMedicale() {
    this.visiteMedicaleSrv.update(this.visiteMedicale)
      .subscribe(data => this.location.back(),
        error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

}
