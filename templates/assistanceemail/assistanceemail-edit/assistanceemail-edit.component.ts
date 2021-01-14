
import { Component, OnInit } from '@angular/core';
import { AssistanceEmailService } from '../assistanceemail.service';
import { AssistanceEmail } from '../assistanceemail';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-assistanceemail-edit',
  templateUrl: './assistanceemail-edit.component.html',
  styleUrls: ['./assistanceemail-edit.component.scss']
})
export class AssistanceEmailEditComponent implements OnInit {

  assistanceEmail: AssistanceEmail;
  constructor(public assistanceEmailSrv: AssistanceEmailService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.assistanceEmail = this.activatedRoute.snapshot.data['assistanceEmail'];
  }

  updateAssistanceEmail() {
    this.assistanceEmailSrv.update(this.assistanceEmail)
      .subscribe(data => this.location.back(),
        error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

}
