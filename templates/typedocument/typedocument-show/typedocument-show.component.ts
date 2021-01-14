import { Component, OnInit } from '@angular/core';
import { Typedocument } from '../typedocument';
import { ActivatedRoute, Router } from '@angular/router';
import { TypedocumentService } from '../typedocument.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-typedocument-show',
  templateUrl: './typedocument-show.component.html',
  styleUrls: ['./typedocument-show.component.scss']
})
export class TypedocumentShowComponent implements OnInit {

  typedocument: Typedocument;
  constructor(public activatedRoute: ActivatedRoute,
    public typedocumentSrv: TypedocumentService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.typedocument = this.activatedRoute.snapshot.data['typedocument'];
  }

  removeTypedocument() {
    this.typedocumentSrv.remove(this.typedocument)
      .subscribe(data => this.router.navigate([this.typedocumentSrv.getRoutePrefix()]),
        error =>  this.typedocumentSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.typedocumentSrv.findOneById(this.typedocument.id)
    .subscribe((data:any)=>this.typedocument=data,
      error=>this.typedocumentSrv.httpSrv.handleError(error));
  }

}

