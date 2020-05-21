import { Component, OnInit } from '@angular/core';
import { EtatDemandeDocument } from '../etat_demande_document';
import { ActivatedRoute, Router } from '@angular/router';
import { EtatDemandeDocumentService } from '../etat_demande_document.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-etat_demande_document-show',
  templateUrl: './etat_demande_document-show.component.html',
  styleUrls: ['./etat_demande_document-show.component.scss']
})
export class EtatDemandeDocumentShowComponent implements OnInit {

  etat_demande_document: EtatDemandeDocument;
  constructor(public activatedRoute: ActivatedRoute,
    public etat_demande_documentSrv: EtatDemandeDocumentService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.etat_demande_document = this.activatedRoute.snapshot.data['etat_demande_document'];
  }

  removeEtatDemandeDocument() {
    this.etat_demande_documentSrv.remove(this.etat_demande_document)
      .subscribe(data => this.router.navigate([this.etat_demande_documentSrv.getRoutePrefix()]),
        error =>  this.etat_demande_documentSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.etat_demande_documentSrv.findOneById(this.etat_demande_document.id)
    .subscribe((data:any)=>this.etat_demande_document=data,
      error=>this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

}

