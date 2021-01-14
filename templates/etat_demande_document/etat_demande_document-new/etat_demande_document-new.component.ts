import { Component, OnInit } from '@angular/core';
import { EtatDemandeDocument } from '../etat_demande_document';
import { EtatDemandeDocumentService } from '../etat_demande_document.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-etat_demande_document-new',
  templateUrl: './etat_demande_document-new.component.html',
  styleUrls: ['./etat_demande_document-new.component.scss']
})
export class EtatDemandeDocumentNewComponent implements OnInit {
  etat_demande_document: EtatDemandeDocument;
  constructor(public etat_demande_documentSrv: EtatDemandeDocumentService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.etat_demande_document = new EtatDemandeDocument();
  }

  ngOnInit() {
  }

  saveEtatDemandeDocument() {
    this.etat_demande_documentSrv.create(this.etat_demande_document)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('EtatDemandeDocument créé avec succès');
        this.etat_demande_document = new EtatDemandeDocument();
      }, error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

  saveEtatDemandeDocumentAndExit() {
    this.etat_demande_documentSrv.create(this.etat_demande_document)
      .subscribe((data: any) => {
        this.router.navigate([this.etat_demande_documentSrv.getRoutePrefix(), data.id]);
      }, error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

}

