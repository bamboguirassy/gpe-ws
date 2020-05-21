import { Component, OnInit } from '@angular/core';
import { EtatDemandeDocument } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { EtatDemandeDocumentService } from '../user.service';
import { etat_demande_documentColumns, allowedEtatDemandeDocumentFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class EtatDemandeDocumentListComponent implements OnInit {

  etat_demande_documents: EtatDemandeDocument[] = [];
  selectedEtatDemandeDocuments: EtatDemandeDocument[];
  selectedEtatDemandeDocument: EtatDemandeDocument;
  clonedEtatDemandeDocuments: EtatDemandeDocument[];

  cMenuItems: MenuItem[]=[];

  tableColumns = etat_demande_documentColumns;
  //allowed fields for filter
  globalFilterFields = allowedEtatDemandeDocumentFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public etat_demande_documentSrv: EtatDemandeDocumentService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('EtatDemandeDocument')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewEtatDemandeDocument(this.selectedEtatDemandeDocument) });
    }
    if(this.authSrv.checkEditAccess('EtatDemandeDocument')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editEtatDemandeDocument(this.selectedEtatDemandeDocument) })
    }
    if(this.authSrv.checkCloneAccess('EtatDemandeDocument')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneEtatDemandeDocument(this.selectedEtatDemandeDocument) })
    }
    if(this.authSrv.checkDeleteAccess('EtatDemandeDocument')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteEtatDemandeDocument(this.selectedEtatDemandeDocument) })
    }

    this.etat_demande_documents = this.activatedRoute.snapshot.data['etat_demande_documents'];
  }

  viewEtatDemandeDocument(etat_demande_document: EtatDemandeDocument) {
      this.router.navigate([this.etat_demande_documentSrv.getRoutePrefix(), etat_demande_document.id]);

  }

  editEtatDemandeDocument(etat_demande_document: EtatDemandeDocument) {
      this.router.navigate([this.etat_demande_documentSrv.getRoutePrefix(), etat_demande_document.id, 'edit']);
  }

  cloneEtatDemandeDocument(etat_demande_document: EtatDemandeDocument) {
      this.router.navigate([this.etat_demande_documentSrv.getRoutePrefix(), etat_demande_document.id, 'clone']);
  }

  deleteEtatDemandeDocument(etat_demande_document: EtatDemandeDocument) {
      this.etat_demande_documentSrv.remove(etat_demande_document)
        .subscribe(data => this.refreshList(), error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

  deleteSelectedEtatDemandeDocuments(etat_demande_document: EtatDemandeDocument) {
    this.etat_demande_documentSrv.removeSelection(this.selectedEtatDemandeDocuments)
      .subscribe(data => this.refreshList(), error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.etat_demande_documentSrv.findAll()
      .subscribe((data: any) => this.etat_demande_documents = data, error => this.etat_demande_documentSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.etat_demande_documents, 'etat_demande_documents');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.etat_demande_documents);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}