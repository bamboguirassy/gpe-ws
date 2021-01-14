import { Component, OnInit } from '@angular/core';
import { AssistanceEmail } from '../assistanceemail';
import { AssistanceEmailService } from '../assistanceemail.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-assistanceemail-new',
  templateUrl: './assistanceemail-new.component.html',
  styleUrls: ['./assistanceemail-new.component.scss']
})
export class AssistanceEmailNewComponent implements OnInit {
  assistanceEmail: AssistanceEmail;
  constructor(public assistanceEmailSrv: AssistanceEmailService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.assistanceEmail = new AssistanceEmail();
  }

  ngOnInit() {
  }

  saveAssistanceEmail() {
    this.assistanceEmailSrv.create(this.assistanceEmail)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('AssistanceEmail créé avec succès');
        this.assistanceEmail = new AssistanceEmail();
      }, error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

  saveAssistanceEmailAndExit() {
    this.assistanceEmailSrv.create(this.assistanceEmail)
      .subscribe((data: any) => {
        this.router.navigate([this.assistanceEmailSrv.getRoutePrefix(), data.id]);
      }, error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

}

