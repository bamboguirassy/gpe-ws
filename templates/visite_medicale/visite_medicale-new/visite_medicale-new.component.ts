import { Component, OnInit } from '@angular/core';
import { VisiteMedicale } from '../visitemedicale';
import { VisiteMedicaleService } from '../visitemedicale.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-visitemedicale-new',
  templateUrl: './visitemedicale-new.component.html',
  styleUrls: ['./visitemedicale-new.component.scss']
})
export class VisiteMedicaleNewComponent implements OnInit {
  visiteMedicale: VisiteMedicale;
  constructor(public visiteMedicaleSrv: VisiteMedicaleService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.visiteMedicale = new VisiteMedicale();
  }

  ngOnInit() {
  }

  saveVisiteMedicale() {
    this.visiteMedicaleSrv.create(this.visiteMedicale)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('VisiteMedicale créé avec succès');
        this.visiteMedicale = new VisiteMedicale();
      }, error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

  saveVisiteMedicaleAndExit() {
    this.visiteMedicaleSrv.create(this.visiteMedicale)
      .subscribe((data: any) => {
        this.router.navigate([this.visiteMedicaleSrv.getRoutePrefix(), data.id]);
      }, error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

}

