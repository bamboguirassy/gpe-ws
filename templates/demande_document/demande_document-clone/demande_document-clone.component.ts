
import { Component, OnInit } from '@angular/core';
import { DemandeDocumentService } from '../demande_document.service';
import { Location } from '@angular/common';
import { DemandeDocument } from '../demande_document';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-demande_document-clone',
  templateUrl: './demande_document-clone.component.html',
  styleUrls: ['./demande_document-clone.component.scss']
})
export class DemandeDocumentCloneComponent implements OnInit {
  demande_document: DemandeDocument;
  original: DemandeDocument;
  constructor(public demande_documentSrv: DemandeDocumentService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['demande_document'];
    this.demande_document = Object.assign({}, this.original);
    this.demande_document.id = null;
  }

  cloneDemandeDocument() {
    console.log(this.demande_document);
    this.demande_documentSrv.clone(this.original, this.demande_document)
      .subscribe((data: any) => {
        this.router.navigate([this.demande_documentSrv.getRoutePrefix(), data.id]);
      }, error => this.demande_documentSrv.httpSrv.handleError(error));
  }

}
