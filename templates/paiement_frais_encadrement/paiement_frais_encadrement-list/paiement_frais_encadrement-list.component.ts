import { Component, OnInit } from '@angular/core';
import { PaiementFraisEncadrement } from '../paiementfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';
import { PaiementFraisEncadrementService } from '../paiementfraisencadrement.service';
import { paiementFraisEncadrementColumns, allowedPaiementFraisEncadrementFieldsForFilter } from '../paiementfraisencadrement.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-paiementfraisencadrement-list',
  templateUrl: './paiementfraisencadrement-list.component.html',
  styleUrls: ['./paiementfraisencadrement-list.component.scss']
})
export class PaiementFraisEncadrementListComponent implements OnInit {

  paiementFraisEncadrements: PaiementFraisEncadrement[] = [];
  selectedPaiementFraisEncadrements: PaiementFraisEncadrement[];
  selectedPaiementFraisEncadrement: PaiementFraisEncadrement;
  clonedPaiementFraisEncadrements: PaiementFraisEncadrement[];

  cMenuItems: MenuItem[]=[];

  tableColumns = paiementFraisEncadrementColumns;
  //allowed fields for filter
  globalFilterFields = allowedPaiementFraisEncadrementFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public paiementFraisEncadrementSrv: PaiementFraisEncadrementService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('PaiementFraisEncadrement')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewPaiementFraisEncadrement(this.selectedPaiementFraisEncadrement) });
    }
    if(this.authSrv.checkEditAccess('PaiementFraisEncadrement')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editPaiementFraisEncadrement(this.selectedPaiementFraisEncadrement) })
    }
    if(this.authSrv.checkCloneAccess('PaiementFraisEncadrement')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.clonePaiementFraisEncadrement(this.selectedPaiementFraisEncadrement) })
    }
    if(this.authSrv.checkDeleteAccess('PaiementFraisEncadrement')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deletePaiementFraisEncadrement(this.selectedPaiementFraisEncadrement) })
    }

    this.paiementFraisEncadrements = this.activatedRoute.snapshot.data['paiementFraisEncadrements'];
  }

  viewPaiementFraisEncadrement(paiementFraisEncadrement: PaiementFraisEncadrement) {
      this.router.navigate([this.paiementFraisEncadrementSrv.getRoutePrefix(), paiementFraisEncadrement.id]);

  }

  editPaiementFraisEncadrement(paiementFraisEncadrement: PaiementFraisEncadrement) {
      this.router.navigate([this.paiementFraisEncadrementSrv.getRoutePrefix(), paiementFraisEncadrement.id, 'edit']);
  }

  clonePaiementFraisEncadrement(paiementFraisEncadrement: PaiementFraisEncadrement) {
      this.router.navigate([this.paiementFraisEncadrementSrv.getRoutePrefix(), paiementFraisEncadrement.id, 'clone']);
  }

  deletePaiementFraisEncadrement(paiementFraisEncadrement: PaiementFraisEncadrement) {
      this.paiementFraisEncadrementSrv.remove(paiementFraisEncadrement)
        .subscribe(data => this.refreshList(), error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

  deleteSelectedPaiementFraisEncadrements(paiementFraisEncadrement: PaiementFraisEncadrement) {
    this.paiementFraisEncadrementSrv.removeSelection(this.selectedPaiementFraisEncadrements)
      .subscribe(data => this.refreshList(), error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.paiementFraisEncadrementSrv.findAll()
      .subscribe((data: any) => this.paiementFraisEncadrements = data, error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.paiementFraisEncadrements, 'paiementFraisEncadrements');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.paiementFraisEncadrements);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}