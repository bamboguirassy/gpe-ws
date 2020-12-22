
import { Component, OnInit } from '@angular/core';
import { AssistanceEmailService } from '../assistanceemail.service';
import { Location } from '@angular/common';
import { AssistanceEmail } from '../assistanceemail';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-assistanceemail-clone',
  templateUrl: './assistanceemail-clone.component.html',
  styleUrls: ['./assistanceemail-clone.component.scss']
})
export class AssistanceEmailCloneComponent implements OnInit {
  assistanceEmail: AssistanceEmail;
  original: AssistanceEmail;
  constructor(public assistanceEmailSrv: AssistanceEmailService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['assistanceEmail'];
    this.assistanceEmail = Object.assign({}, this.original);
    this.assistanceEmail.id = null;
  }

  cloneAssistanceEmail() {
    console.log(this.assistanceEmail);
    this.assistanceEmailSrv.clone(this.original, this.assistanceEmail)
      .subscribe((data: any) => {
        this.router.navigate([this.assistanceEmailSrv.getRoutePrefix(), data.id]);
      }, error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

}
