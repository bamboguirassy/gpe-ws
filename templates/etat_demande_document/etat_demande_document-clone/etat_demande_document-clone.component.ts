
import { Component, OnInit } from '@angular/core';
import { EtatDemandeDocumentService } from '../etat_demande_document.service';
import { Location } from '@angular/common';
import { EtatDemandeDocument } from '../etat_demande_document';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-etat_demande_document-clone',
  templateUrl: './etat_demande_document-clone.component.html',
  styleUrls: ['./etat_demande_document-clone.component.scss']
})
export class EtatDemandeDocumentCloneComponent implements OnInit {
  etat_demande_document: EtatDemandeDocument;
  original: EtatDemandeDocument;
  constructor(public etat_demande_documentSrv: EtatDemandeDocumentService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['etat_demande_document'];
    this.etat_demande_document = Object.assign({}, this.original);
    this.etat_demande_document.id = null;
  }

  cloneEtatDemandeDocument() {
    console.log(this.etat_demande_document);
    this.etat_demande_documentSrv.clone(this.original, this.etat_demande_document)
      .subscribe((data: any) => {
        this.router.navigate([this.etat_demande_documentSrv.getRoutePrefix(), data.id]);
      }, error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

}
