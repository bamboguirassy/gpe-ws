import { Component, OnInit } from '@angular/core';
import { VisiteMedicale } from '../visitemedicale';
import { ActivatedRoute, Router } from '@angular/router';
import { VisiteMedicaleService } from '../visitemedicale.service';
import { visiteMedicaleColumns, allowedVisiteMedicaleFieldsForFilter } from '../visitemedicale.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-visitemedicale-list',
  templateUrl: './visitemedicale-list.component.html',
  styleUrls: ['./visitemedicale-list.component.scss']
})
export class VisiteMedicaleListComponent implements OnInit {

  visiteMedicales: VisiteMedicale[] = [];
  selectedVisiteMedicales: VisiteMedicale[];
  selectedVisiteMedicale: VisiteMedicale;
  clonedVisiteMedicales: VisiteMedicale[];

  cMenuItems: MenuItem[]=[];

  tableColumns = visiteMedicaleColumns;
  //allowed fields for filter
  globalFilterFields = allowedVisiteMedicaleFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public visiteMedicaleSrv: VisiteMedicaleService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('VisiteMedicale')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewVisiteMedicale(this.selectedVisiteMedicale) });
    }
    if(this.authSrv.checkEditAccess('VisiteMedicale')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editVisiteMedicale(this.selectedVisiteMedicale) })
    }
    if(this.authSrv.checkCloneAccess('VisiteMedicale')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneVisiteMedicale(this.selectedVisiteMedicale) })
    }
    if(this.authSrv.checkDeleteAccess('VisiteMedicale')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteVisiteMedicale(this.selectedVisiteMedicale) })
    }

    this.visiteMedicales = this.activatedRoute.snapshot.data['visiteMedicales'];
  }

  viewVisiteMedicale(visiteMedicale: VisiteMedicale) {
      this.router.navigate([this.visiteMedicaleSrv.getRoutePrefix(), visiteMedicale.id]);

  }

  editVisiteMedicale(visiteMedicale: VisiteMedicale) {
      this.router.navigate([this.visiteMedicaleSrv.getRoutePrefix(), visiteMedicale.id, 'edit']);
  }

  cloneVisiteMedicale(visiteMedicale: VisiteMedicale) {
      this.router.navigate([this.visiteMedicaleSrv.getRoutePrefix(), visiteMedicale.id, 'clone']);
  }

  deleteVisiteMedicale(visiteMedicale: VisiteMedicale) {
      this.visiteMedicaleSrv.remove(visiteMedicale)
        .subscribe(data => this.refreshList(), error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

  deleteSelectedVisiteMedicales(visiteMedicale: VisiteMedicale) {
    this.visiteMedicaleSrv.removeSelection(this.selectedVisiteMedicales)
      .subscribe(data => this.refreshList(), error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.visiteMedicaleSrv.findAll()
      .subscribe((data: any) => this.visiteMedicales = data, error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.visiteMedicales, 'visiteMedicales');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.visiteMedicales);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}