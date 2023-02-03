import { Component, OnInit } from '@angular/core';
import { InscriptionTemporaire } from '../inscriptiontemporaire';
import { ActivatedRoute, Router } from '@angular/router';
import { InscriptionTemporaireService } from '../inscriptiontemporaire.service';
import { inscriptionTemporaireColumns, allowedInscriptionTemporaireFieldsForFilter } from '../inscriptiontemporaire.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-inscriptiontemporaire-list',
  templateUrl: './inscriptiontemporaire-list.component.html',
  styleUrls: ['./inscriptiontemporaire-list.component.scss']
})
export class InscriptionTemporaireListComponent implements OnInit {

  inscriptionTemporaires: InscriptionTemporaire[] = [];
  selectedInscriptionTemporaires: InscriptionTemporaire[];
  selectedInscriptionTemporaire: InscriptionTemporaire;
  clonedInscriptionTemporaires: InscriptionTemporaire[];

  cMenuItems: MenuItem[]=[];

  tableColumns = inscriptionTemporaireColumns;
  //allowed fields for filter
  globalFilterFields = allowedInscriptionTemporaireFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public inscriptionTemporaireSrv: InscriptionTemporaireService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('InscriptionTemporaire')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewInscriptionTemporaire(this.selectedInscriptionTemporaire) });
    }
    if(this.authSrv.checkEditAccess('InscriptionTemporaire')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editInscriptionTemporaire(this.selectedInscriptionTemporaire) })
    }
    if(this.authSrv.checkCloneAccess('InscriptionTemporaire')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneInscriptionTemporaire(this.selectedInscriptionTemporaire) })
    }
    if(this.authSrv.checkDeleteAccess('InscriptionTemporaire')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteInscriptionTemporaire(this.selectedInscriptionTemporaire) })
    }

    this.inscriptionTemporaires = this.activatedRoute.snapshot.data['inscriptionTemporaires'];
  }

  viewInscriptionTemporaire(inscriptionTemporaire: InscriptionTemporaire) {
      this.router.navigate([this.inscriptionTemporaireSrv.getRoutePrefix(), inscriptionTemporaire.id]);

  }

  editInscriptionTemporaire(inscriptionTemporaire: InscriptionTemporaire) {
      this.router.navigate([this.inscriptionTemporaireSrv.getRoutePrefix(), inscriptionTemporaire.id, 'edit']);
  }

  cloneInscriptionTemporaire(inscriptionTemporaire: InscriptionTemporaire) {
      this.router.navigate([this.inscriptionTemporaireSrv.getRoutePrefix(), inscriptionTemporaire.id, 'clone']);
  }

  deleteInscriptionTemporaire(inscriptionTemporaire: InscriptionTemporaire) {
      this.inscriptionTemporaireSrv.remove(inscriptionTemporaire)
        .subscribe(data => this.refreshList(), error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

  deleteSelectedInscriptionTemporaires(inscriptionTemporaire: InscriptionTemporaire) {
    this.inscriptionTemporaireSrv.removeSelection(this.selectedInscriptionTemporaires)
      .subscribe(data => this.refreshList(), error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.inscriptionTemporaireSrv.findAll()
      .subscribe((data: any) => this.inscriptionTemporaires = data, error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.inscriptionTemporaires, 'inscriptionTemporaires');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.inscriptionTemporaires);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}