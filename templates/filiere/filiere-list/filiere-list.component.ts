import { Component, OnInit } from '@angular/core';
import { Filiere } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { FiliereService } from '../user.service';
import { filiereColumns, allowedFiliereFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class FiliereListComponent implements OnInit {

  filieres: Filiere[] = [];
  selectedFilieres: Filiere[];
  selectedFiliere: Filiere;
  clonedFilieres: Filiere[];

  cMenuItems: MenuItem[]=[];

  tableColumns = filiereColumns;
  //allowed fields for filter
  globalFilterFields = allowedFiliereFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public filiereSrv: FiliereService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Filiere')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewFiliere(this.selectedFiliere) });
    }
    if(this.authSrv.checkEditAccess('Filiere')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editFiliere(this.selectedFiliere) })
    }
    if(this.authSrv.checkCloneAccess('Filiere')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneFiliere(this.selectedFiliere) })
    }
    if(this.authSrv.checkDeleteAccess('Filiere')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteFiliere(this.selectedFiliere) })
    }

    this.filieres = this.activatedRoute.snapshot.data['filieres'];
  }

  viewFiliere(filiere: Filiere) {
      this.router.navigate([this.filiereSrv.getRoutePrefix(), filiere.id]);

  }

  editFiliere(filiere: Filiere) {
      this.router.navigate([this.filiereSrv.getRoutePrefix(), filiere.id, 'edit']);
  }

  cloneFiliere(filiere: Filiere) {
      this.router.navigate([this.filiereSrv.getRoutePrefix(), filiere.id, 'clone']);
  }

  deleteFiliere(filiere: Filiere) {
      this.filiereSrv.remove(filiere)
        .subscribe(data => this.refreshList(), error => this.filiereSrv.httpSrv.handleError(error));
  }

  deleteSelectedFilieres(filiere: Filiere) {
    this.filiereSrv.removeSelection(this.selectedFilieres)
      .subscribe(data => this.refreshList(), error => this.filiereSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.filiereSrv.findAll()
      .subscribe((data: any) => this.filieres = data, error => this.filiereSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.filieres, 'filieres');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.filieres);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}