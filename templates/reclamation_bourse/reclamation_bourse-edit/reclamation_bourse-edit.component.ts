
import { Component, OnInit } from '@angular/core';
import { ReclamationBourseService } from '../reclamation_bourse.service';
import { ReclamationBourse } from '../reclamation_bourse';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-reclamation_bourse-edit',
  templateUrl: './reclamation_bourse-edit.component.html',
  styleUrls: ['./reclamation_bourse-edit.component.scss']
})
export class ReclamationBourseEditComponent implements OnInit {

  reclamation_bourse: ReclamationBourse;
  constructor(public reclamation_bourseSrv: ReclamationBourseService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.reclamation_bourse = this.activatedRoute.snapshot.data['reclamation_bourse'];
  }

  updateReclamationBourse() {
    this.reclamation_bourseSrv.update(this.reclamation_bourse)
      .subscribe(data => this.location.back(),
        error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

}
