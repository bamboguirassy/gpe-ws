import { Component, OnInit } from '@angular/core';
import { AssistanceEmail } from '../assistanceemail';
import { ActivatedRoute, Router } from '@angular/router';
import { AssistanceEmailService } from '../assistanceemail.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-assistanceemail-show',
  templateUrl: './assistanceemail-show.component.html',
  styleUrls: ['./assistanceemail-show.component.scss']
})
export class AssistanceEmailShowComponent implements OnInit {

  assistanceEmail: AssistanceEmail;
  constructor(public activatedRoute: ActivatedRoute,
    public assistanceEmailSrv: AssistanceEmailService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.assistanceEmail = this.activatedRoute.snapshot.data['assistanceEmail'];
  }

  removeAssistanceEmail() {
    this.assistanceEmailSrv.remove(this.assistanceEmail)
      .subscribe(data => this.router.navigate([this.assistanceEmailSrv.getRoutePrefix()]),
        error =>  this.assistanceEmailSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.assistanceEmailSrv.findOneById(this.assistanceEmail.id)
    .subscribe((data:any)=>this.assistanceEmail=data,
      error=>this.assistanceEmailSrv.httpSrv.handleError(error));
  }

}

