import { Component, OnInit } from '@angular/core';
import { Typedocument } from '../typedocument';
import { ActivatedRoute, Router } from '@angular/router';
import { TypedocumentService } from '../typedocument.service';
import { typedocumentColumns, allowedTypedocumentFieldsForFilter } from '../typedocument.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-typedocument-list',
  templateUrl: './typedocument-list.component.html',
  styleUrls: ['./typedocument-list.component.scss']
})
export class TypedocumentListComponent implements OnInit {

  typedocuments: Typedocument[] = [];
  selectedTypedocuments: Typedocument[];
  selectedTypedocument: Typedocument;
  clonedTypedocuments: Typedocument[];

  cMenuItems: MenuItem[]=[];

  tableColumns = typedocumentColumns;
  //allowed fields for filter
  globalFilterFields = allowedTypedocumentFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public typedocumentSrv: TypedocumentService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Typedocument')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewTypedocument(this.selectedTypedocument) });
    }
    if(this.authSrv.checkEditAccess('Typedocument')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editTypedocument(this.selectedTypedocument) })
    }
    if(this.authSrv.checkCloneAccess('Typedocument')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneTypedocument(this.selectedTypedocument) })
    }
    if(this.authSrv.checkDeleteAccess('Typedocument')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteTypedocument(this.selectedTypedocument) })
    }

    this.typedocuments = this.activatedRoute.snapshot.data['typedocuments'];
  }

  viewTypedocument(typedocument: Typedocument) {
      this.router.navigate([this.typedocumentSrv.getRoutePrefix(), typedocument.id]);

  }

  editTypedocument(typedocument: Typedocument) {
      this.router.navigate([this.typedocumentSrv.getRoutePrefix(), typedocument.id, 'edit']);
  }

  cloneTypedocument(typedocument: Typedocument) {
      this.router.navigate([this.typedocumentSrv.getRoutePrefix(), typedocument.id, 'clone']);
  }

  deleteTypedocument(typedocument: Typedocument) {
      this.typedocumentSrv.remove(typedocument)
        .subscribe(data => this.refreshList(), error => this.typedocumentSrv.httpSrv.handleError(error));
  }

  deleteSelectedTypedocuments(typedocument: Typedocument) {
    this.typedocumentSrv.removeSelection(this.selectedTypedocuments)
      .subscribe(data => this.refreshList(), error => this.typedocumentSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.typedocumentSrv.findAll()
      .subscribe((data: any) => this.typedocuments = data, error => this.typedocumentSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.typedocuments, 'typedocuments');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.typedocuments);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}