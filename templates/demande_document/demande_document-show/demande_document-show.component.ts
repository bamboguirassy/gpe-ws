import { Component, OnInit } from '@angular/core';
import { DemandeDocument } from '../demande_document';
import { ActivatedRoute, Router } from '@angular/router';
import { DemandeDocumentService } from '../demande_document.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-demande_document-show',
  templateUrl: './demande_document-show.component.html',
  styleUrls: ['./demande_document-show.component.scss']
})
export class DemandeDocumentShowComponent implements OnInit {

  demande_document: DemandeDocument;
  constructor(public activatedRoute: ActivatedRoute,
    public demande_documentSrv: DemandeDocumentService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.demande_document = this.activatedRoute.snapshot.data['demande_document'];
  }

  removeDemandeDocument() {
    this.demande_documentSrv.remove(this.demande_document)
      .subscribe(data => this.router.navigate([this.demande_documentSrv.getRoutePrefix()]),
        error =>  this.demande_documentSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.demande_documentSrv.findOneById(this.demande_document.id)
    .subscribe((data:any)=>this.demande_document=data,
      error=>this.demande_documentSrv.httpSrv.handleError(error));
  }

}

