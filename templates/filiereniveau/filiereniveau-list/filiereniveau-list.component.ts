import { Component, OnInit } from '@angular/core';
import { Filiereniveau } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { FiliereniveauService } from '../user.service';
import { filiereniveauColumns, allowedFiliereniveauFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class FiliereniveauListComponent implements OnInit {

  filiereniveaus: Filiereniveau[] = [];
  selectedFiliereniveaus: Filiereniveau[];
  selectedFiliereniveau: Filiereniveau;
  clonedFiliereniveaus: Filiereniveau[];

  cMenuItems: MenuItem[]=[];

  tableColumns = filiereniveauColumns;
  //allowed fields for filter
  globalFilterFields = allowedFiliereniveauFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public filiereniveauSrv: FiliereniveauService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Filiereniveau')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewFiliereniveau(this.selectedFiliereniveau) });
    }
    if(this.authSrv.checkEditAccess('Filiereniveau')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editFiliereniveau(this.selectedFiliereniveau) })
    }
    if(this.authSrv.checkCloneAccess('Filiereniveau')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneFiliereniveau(this.selectedFiliereniveau) })
    }
    if(this.authSrv.checkDeleteAccess('Filiereniveau')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteFiliereniveau(this.selectedFiliereniveau) })
    }

    this.filiereniveaus = this.activatedRoute.snapshot.data['filiereniveaus'];
  }

  viewFiliereniveau(filiereniveau: Filiereniveau) {
      this.router.navigate([this.filiereniveauSrv.getRoutePrefix(), filiereniveau.id]);

  }

  editFiliereniveau(filiereniveau: Filiereniveau) {
      this.router.navigate([this.filiereniveauSrv.getRoutePrefix(), filiereniveau.id, 'edit']);
  }

  cloneFiliereniveau(filiereniveau: Filiereniveau) {
      this.router.navigate([this.filiereniveauSrv.getRoutePrefix(), filiereniveau.id, 'clone']);
  }

  deleteFiliereniveau(filiereniveau: Filiereniveau) {
      this.filiereniveauSrv.remove(filiereniveau)
        .subscribe(data => this.refreshList(), error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

  deleteSelectedFiliereniveaus(filiereniveau: Filiereniveau) {
    this.filiereniveauSrv.removeSelection(this.selectedFiliereniveaus)
      .subscribe(data => this.refreshList(), error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.filiereniveauSrv.findAll()
      .subscribe((data: any) => this.filiereniveaus = data, error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.filiereniveaus, 'filiereniveaus');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.filiereniveaus);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}