import { Component, OnInit } from '@angular/core';
import { ParamFraisEncadrement } from '../paramfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';
import { ParamFraisEncadrementService } from '../paramfraisencadrement.service';
import { paramFraisEncadrementColumns, allowedParamFraisEncadrementFieldsForFilter } from '../paramfraisencadrement.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-paramfraisencadrement-list',
  templateUrl: './paramfraisencadrement-list.component.html',
  styleUrls: ['./paramfraisencadrement-list.component.scss']
})
export class ParamFraisEncadrementListComponent implements OnInit {

  paramFraisEncadrements: ParamFraisEncadrement[] = [];
  selectedParamFraisEncadrements: ParamFraisEncadrement[];
  selectedParamFraisEncadrement: ParamFraisEncadrement;
  clonedParamFraisEncadrements: ParamFraisEncadrement[];

  cMenuItems: MenuItem[]=[];

  tableColumns = paramFraisEncadrementColumns;
  //allowed fields for filter
  globalFilterFields = allowedParamFraisEncadrementFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public paramFraisEncadrementSrv: ParamFraisEncadrementService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('ParamFraisEncadrement')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewParamFraisEncadrement(this.selectedParamFraisEncadrement) });
    }
    if(this.authSrv.checkEditAccess('ParamFraisEncadrement')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editParamFraisEncadrement(this.selectedParamFraisEncadrement) })
    }
    if(this.authSrv.checkCloneAccess('ParamFraisEncadrement')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneParamFraisEncadrement(this.selectedParamFraisEncadrement) })
    }
    if(this.authSrv.checkDeleteAccess('ParamFraisEncadrement')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteParamFraisEncadrement(this.selectedParamFraisEncadrement) })
    }

    this.paramFraisEncadrements = this.activatedRoute.snapshot.data['paramFraisEncadrements'];
  }

  viewParamFraisEncadrement(paramFraisEncadrement: ParamFraisEncadrement) {
      this.router.navigate([this.paramFraisEncadrementSrv.getRoutePrefix(), paramFraisEncadrement.id]);

  }

  editParamFraisEncadrement(paramFraisEncadrement: ParamFraisEncadrement) {
      this.router.navigate([this.paramFraisEncadrementSrv.getRoutePrefix(), paramFraisEncadrement.id, 'edit']);
  }

  cloneParamFraisEncadrement(paramFraisEncadrement: ParamFraisEncadrement) {
      this.router.navigate([this.paramFraisEncadrementSrv.getRoutePrefix(), paramFraisEncadrement.id, 'clone']);
  }

  deleteParamFraisEncadrement(paramFraisEncadrement: ParamFraisEncadrement) {
      this.paramFraisEncadrementSrv.remove(paramFraisEncadrement)
        .subscribe(data => this.refreshList(), error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

  deleteSelectedParamFraisEncadrements(paramFraisEncadrement: ParamFraisEncadrement) {
    this.paramFraisEncadrementSrv.removeSelection(this.selectedParamFraisEncadrements)
      .subscribe(data => this.refreshList(), error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.paramFraisEncadrementSrv.findAll()
      .subscribe((data: any) => this.paramFraisEncadrements = data, error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.paramFraisEncadrements, 'paramFraisEncadrements');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.paramFraisEncadrements);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}