
import { Component, OnInit } from '@angular/core';
import { TypedocumentService } from '../typedocument.service';
import { Typedocument } from '../typedocument';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-typedocument-edit',
  templateUrl: './typedocument-edit.component.html',
  styleUrls: ['./typedocument-edit.component.scss']
})
export class TypedocumentEditComponent implements OnInit {

  typedocument: Typedocument;
  constructor(public typedocumentSrv: TypedocumentService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.typedocument = this.activatedRoute.snapshot.data['typedocument'];
  }

  updateTypedocument() {
    this.typedocumentSrv.update(this.typedocument)
      .subscribe(data => this.location.back(),
        error => this.typedocumentSrv.httpSrv.handleError(error));
  }

}
