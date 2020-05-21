import { Component, OnInit } from '@angular/core';
import { DemandeDocument } from '../demande_document';
import { DemandeDocumentService } from '../demande_document.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-demande_document-new',
  templateUrl: './demande_document-new.component.html',
  styleUrls: ['./demande_document-new.component.scss']
})
export class DemandeDocumentNewComponent implements OnInit {
  demande_document: DemandeDocument;
  constructor(public demande_documentSrv: DemandeDocumentService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.demande_document = new DemandeDocument();
  }

  ngOnInit() {
  }

  saveDemandeDocument() {
    this.demande_documentSrv.create(this.demande_document)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('DemandeDocument créé avec succès');
        this.demande_document = new DemandeDocument();
      }, error => this.demande_documentSrv.httpSrv.handleError(error));
  }

  saveDemandeDocumentAndExit() {
    this.demande_documentSrv.create(this.demande_document)
      .subscribe((data: any) => {
        this.router.navigate([this.demande_documentSrv.getRoutePrefix(), data.id]);
      }, error => this.demande_documentSrv.httpSrv.handleError(error));
  }

}

