import { Component, OnInit } from '@angular/core';
import { ReclamationBourse } from '../reclamation_bourse';
import { ReclamationBourseService } from '../reclamation_bourse.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-reclamation_bourse-new',
  templateUrl: './reclamation_bourse-new.component.html',
  styleUrls: ['./reclamation_bourse-new.component.scss']
})
export class ReclamationBourseNewComponent implements OnInit {
  reclamation_bourse: ReclamationBourse;
  constructor(public reclamation_bourseSrv: ReclamationBourseService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.reclamation_bourse = new ReclamationBourse();
  }

  ngOnInit() {
  }

  saveReclamationBourse() {
    this.reclamation_bourseSrv.create(this.reclamation_bourse)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('ReclamationBourse créé avec succès');
        this.reclamation_bourse = new ReclamationBourse();
      }, error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

  saveReclamationBourseAndExit() {
    this.reclamation_bourseSrv.create(this.reclamation_bourse)
      .subscribe((data: any) => {
        this.router.navigate([this.reclamation_bourseSrv.getRoutePrefix(), data.id]);
      }, error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

}

