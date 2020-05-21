import { Component, OnInit } from '@angular/core';
import { HistoriqueEtatDemande } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { HistoriqueEtatDemandeService } from '../user.service';
import { historique_etat_demandeColumns, allowedHistoriqueEtatDemandeFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class HistoriqueEtatDemandeListComponent implements OnInit {

  historique_etat_demandes: HistoriqueEtatDemande[] = [];
  selectedHistoriqueEtatDemandes: HistoriqueEtatDemande[];
  selectedHistoriqueEtatDemande: HistoriqueEtatDemande;
  clonedHistoriqueEtatDemandes: HistoriqueEtatDemande[];

  cMenuItems: MenuItem[]=[];

  tableColumns = historique_etat_demandeColumns;
  //allowed fields for filter
  globalFilterFields = allowedHistoriqueEtatDemandeFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public historique_etat_demandeSrv: HistoriqueEtatDemandeService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('HistoriqueEtatDemande')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewHistoriqueEtatDemande(this.selectedHistoriqueEtatDemande) });
    }
    if(this.authSrv.checkEditAccess('HistoriqueEtatDemande')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editHistoriqueEtatDemande(this.selectedHistoriqueEtatDemande) })
    }
    if(this.authSrv.checkCloneAccess('HistoriqueEtatDemande')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneHistoriqueEtatDemande(this.selectedHistoriqueEtatDemande) })
    }
    if(this.authSrv.checkDeleteAccess('HistoriqueEtatDemande')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteHistoriqueEtatDemande(this.selectedHistoriqueEtatDemande) })
    }

    this.historique_etat_demandes = this.activatedRoute.snapshot.data['historique_etat_demandes'];
  }

  viewHistoriqueEtatDemande(historique_etat_demande: HistoriqueEtatDemande) {
      this.router.navigate([this.historique_etat_demandeSrv.getRoutePrefix(), historique_etat_demande.id]);

  }

  editHistoriqueEtatDemande(historique_etat_demande: HistoriqueEtatDemande) {
      this.router.navigate([this.historique_etat_demandeSrv.getRoutePrefix(), historique_etat_demande.id, 'edit']);
  }

  cloneHistoriqueEtatDemande(historique_etat_demande: HistoriqueEtatDemande) {
      this.router.navigate([this.historique_etat_demandeSrv.getRoutePrefix(), historique_etat_demande.id, 'clone']);
  }

  deleteHistoriqueEtatDemande(historique_etat_demande: HistoriqueEtatDemande) {
      this.historique_etat_demandeSrv.remove(historique_etat_demande)
        .subscribe(data => this.refreshList(), error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

  deleteSelectedHistoriqueEtatDemandes(historique_etat_demande: HistoriqueEtatDemande) {
    this.historique_etat_demandeSrv.removeSelection(this.selectedHistoriqueEtatDemandes)
      .subscribe(data => this.refreshList(), error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.historique_etat_demandeSrv.findAll()
      .subscribe((data: any) => this.historique_etat_demandes = data, error => this.historique_etat_demandeSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.historique_etat_demandes, 'historique_etat_demandes');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.historique_etat_demandes);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}