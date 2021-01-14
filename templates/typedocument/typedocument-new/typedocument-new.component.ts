import { Component, OnInit } from '@angular/core';
import { Typedocument } from '../typedocument';
import { TypedocumentService } from '../typedocument.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-typedocument-new',
  templateUrl: './typedocument-new.component.html',
  styleUrls: ['./typedocument-new.component.scss']
})
export class TypedocumentNewComponent implements OnInit {
  typedocument: Typedocument;
  constructor(public typedocumentSrv: TypedocumentService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.typedocument = new Typedocument();
  }

  ngOnInit() {
  }

  saveTypedocument() {
    this.typedocumentSrv.create(this.typedocument)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Typedocument créé avec succès');
        this.typedocument = new Typedocument();
      }, error => this.typedocumentSrv.httpSrv.handleError(error));
  }

  saveTypedocumentAndExit() {
    this.typedocumentSrv.create(this.typedocument)
      .subscribe((data: any) => {
        this.router.navigate([this.typedocumentSrv.getRoutePrefix(), data.id]);
      }, error => this.typedocumentSrv.httpSrv.handleError(error));
  }

}

