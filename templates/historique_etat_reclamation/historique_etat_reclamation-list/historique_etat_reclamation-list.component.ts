import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatReclamation } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { HistoriqueEtatReclamationService } from '../user.service';
import { historique_etat_reclamationColumns, allowedHistoriqueEtatReclamationFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class HistoriqueEtatReclamationListComponent implements OnInit {

  historique_etat_reclamations: HistoriqueEtatReclamation[] = [];
  selectedHistoriqueEtatReclamations: HistoriqueEtatReclamation[];
  selectedHistoriqueEtatReclamation: HistoriqueEtatReclamation;
  clonedHistoriqueEtatReclamations: HistoriqueEtatReclamation[];

  cMenuItems: MenuItem[]=[];

  tableColumns = historique_etat_reclamationColumns;
  //allowed fields for filter
  globalFilterFields = allowedHistoriqueEtatReclamationFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public historique_etat_reclamationSrv: HistoriqueEtatReclamationService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('HistoriqueEtatReclamation')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewHistoriqueEtatReclamation(this.selectedHistoriqueEtatReclamation) });
    }
    if(this.authSrv.checkEditAccess('HistoriqueEtatReclamation')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editHistoriqueEtatReclamation(this.selectedHistoriqueEtatReclamation) })
    }
    if(this.authSrv.checkCloneAccess('HistoriqueEtatReclamation')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneHistoriqueEtatReclamation(this.selectedHistoriqueEtatReclamation) })
    }
    if(this.authSrv.checkDeleteAccess('HistoriqueEtatReclamation')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteHistoriqueEtatReclamation(this.selectedHistoriqueEtatReclamation) })
    }

    this.historique_etat_reclamations = this.activatedRoute.snapshot.data['historique_etat_reclamations'];
  }

  viewHistoriqueEtatReclamation(historique_etat_reclamation: HistoriqueEtatReclamation) {
      this.router.navigate([this.historique_etat_reclamationSrv.getRoutePrefix(), historique_etat_reclamation.id]);

  }

  editHistoriqueEtatReclamation(historique_etat_reclamation: HistoriqueEtatReclamation) {
      this.router.navigate([this.historique_etat_reclamationSrv.getRoutePrefix(), historique_etat_reclamation.id, 'edit']);
  }

  cloneHistoriqueEtatReclamation(historique_etat_reclamation: HistoriqueEtatReclamation) {
      this.router.navigate([this.historique_etat_reclamationSrv.getRoutePrefix(), historique_etat_reclamation.id, 'clone']);
  }

  deleteHistoriqueEtatReclamation(historique_etat_reclamation: HistoriqueEtatReclamation) {
      this.historique_etat_reclamationSrv.remove(historique_etat_reclamation)
        .subscribe(data => this.refreshList(), error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

  deleteSelectedHistoriqueEtatReclamations(historique_etat_reclamation: HistoriqueEtatReclamation) {
    this.historique_etat_reclamationSrv.removeSelection(this.selectedHistoriqueEtatReclamations)
      .subscribe(data => this.refreshList(), error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.historique_etat_reclamationSrv.findAll()
      .subscribe((data: any) => this.historique_etat_reclamations = data, error => this.historique_etat_reclamationSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.historique_etat_reclamations, 'historique_etat_reclamations');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.historique_etat_reclamations);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}