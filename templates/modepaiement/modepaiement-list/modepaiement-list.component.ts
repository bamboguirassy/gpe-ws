import { Component, OnInit } from '@angular/core';
import { Modepaiement } from '../modepaiement';
import { ActivatedRoute, Router } from '@angular/router';
import { ModepaiementService } from '../modepaiement.service';
import { modepaiementColumns, allowedModepaiementFieldsForFilter } from '../modepaiement.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-modepaiement-list',
  templateUrl: './modepaiement-list.component.html',
  styleUrls: ['./modepaiement-list.component.scss']
})
export class ModepaiementListComponent implements OnInit {

  modepaiements: Modepaiement[] = [];
  selectedModepaiements: Modepaiement[];
  selectedModepaiement: Modepaiement;
  clonedModepaiements: Modepaiement[];

  cMenuItems: MenuItem[]=[];

  tableColumns = modepaiementColumns;
  //allowed fields for filter
  globalFilterFields = allowedModepaiementFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public modepaiementSrv: ModepaiementService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Modepaiement')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewModepaiement(this.selectedModepaiement) });
    }
    if(this.authSrv.checkEditAccess('Modepaiement')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editModepaiement(this.selectedModepaiement) })
    }
    if(this.authSrv.checkCloneAccess('Modepaiement')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneModepaiement(this.selectedModepaiement) })
    }
    if(this.authSrv.checkDeleteAccess('Modepaiement')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteModepaiement(this.selectedModepaiement) })
    }

    this.modepaiements = this.activatedRoute.snapshot.data['modepaiements'];
  }

  viewModepaiement(modepaiement: Modepaiement) {
      this.router.navigate([this.modepaiementSrv.getRoutePrefix(), modepaiement.id]);

  }

  editModepaiement(modepaiement: Modepaiement) {
      this.router.navigate([this.modepaiementSrv.getRoutePrefix(), modepaiement.id, 'edit']);
  }

  cloneModepaiement(modepaiement: Modepaiement) {
      this.router.navigate([this.modepaiementSrv.getRoutePrefix(), modepaiement.id, 'clone']);
  }

  deleteModepaiement(modepaiement: Modepaiement) {
      this.modepaiementSrv.remove(modepaiement)
        .subscribe(data => this.refreshList(), error => this.modepaiementSrv.httpSrv.handleError(error));
  }

  deleteSelectedModepaiements(modepaiement: Modepaiement) {
    this.modepaiementSrv.removeSelection(this.selectedModepaiements)
      .subscribe(data => this.refreshList(), error => this.modepaiementSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.modepaiementSrv.findAll()
      .subscribe((data: any) => this.modepaiements = data, error => this.modepaiementSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.modepaiements, 'modepaiements');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.modepaiements);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}