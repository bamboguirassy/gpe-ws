
import { Component, OnInit } from '@angular/core';
import { EtatDemandeDocumentService } from '../etat_demande_document.service';
import { EtatDemandeDocument } from '../etat_demande_document';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-etat_demande_document-edit',
  templateUrl: './etat_demande_document-edit.component.html',
  styleUrls: ['./etat_demande_document-edit.component.scss']
})
export class EtatDemandeDocumentEditComponent implements OnInit {

  etat_demande_document: EtatDemandeDocument;
  constructor(public etat_demande_documentSrv: EtatDemandeDocumentService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.etat_demande_document = this.activatedRoute.snapshot.data['etat_demande_document'];
  }

  updateEtatDemandeDocument() {
    this.etat_demande_documentSrv.update(this.etat_demande_document)
      .subscribe(data => this.location.back(),
        error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

}
