
import { Component, OnInit } from '@angular/core';
import { DemandeDocumentService } from '../demande_document.service';
import { DemandeDocument } from '../demande_document';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-demande_document-edit',
  templateUrl: './demande_document-edit.component.html',
  styleUrls: ['./demande_document-edit.component.scss']
})
export class DemandeDocumentEditComponent implements OnInit {

  demande_document: DemandeDocument;
  constructor(public demande_documentSrv: DemandeDocumentService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.demande_document = this.activatedRoute.snapshot.data['demande_document'];
  }

  updateDemandeDocument() {
    this.demande_documentSrv.update(this.demande_document)
      .subscribe(data => this.location.back(),
        error => this.demande_documentSrv.httpSrv.handleError(error));
  }

}
