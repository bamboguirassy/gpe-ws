import { Component, OnInit } from '@angular/core';
import { Specialite } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { SpecialiteService } from '../user.service';
import { specialiteColumns, allowedSpecialiteFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class SpecialiteListComponent implements OnInit {

  specialites: Specialite[] = [];
  selectedSpecialites: Specialite[];
  selectedSpecialite: Specialite;
  clonedSpecialites: Specialite[];

  cMenuItems: MenuItem[]=[];

  tableColumns = specialiteColumns;
  //allowed fields for filter
  globalFilterFields = allowedSpecialiteFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public specialiteSrv: SpecialiteService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Specialite')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewSpecialite(this.selectedSpecialite) });
    }
    if(this.authSrv.checkEditAccess('Specialite')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editSpecialite(this.selectedSpecialite) })
    }
    if(this.authSrv.checkCloneAccess('Specialite')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneSpecialite(this.selectedSpecialite) })
    }
    if(this.authSrv.checkDeleteAccess('Specialite')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteSpecialite(this.selectedSpecialite) })
    }

    this.specialites = this.activatedRoute.snapshot.data['specialites'];
  }

  viewSpecialite(specialite: Specialite) {
      this.router.navigate([this.specialiteSrv.getRoutePrefix(), specialite.id]);

  }

  editSpecialite(specialite: Specialite) {
      this.router.navigate([this.specialiteSrv.getRoutePrefix(), specialite.id, 'edit']);
  }

  cloneSpecialite(specialite: Specialite) {
      this.router.navigate([this.specialiteSrv.getRoutePrefix(), specialite.id, 'clone']);
  }

  deleteSpecialite(specialite: Specialite) {
      this.specialiteSrv.remove(specialite)
        .subscribe(data => this.refreshList(), error => this.specialiteSrv.httpSrv.handleError(error));
  }

  deleteSelectedSpecialites(specialite: Specialite) {
    this.specialiteSrv.removeSelection(this.selectedSpecialites)
      .subscribe(data => this.refreshList(), error => this.specialiteSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.specialiteSrv.findAll()
      .subscribe((data: any) => this.specialites = data, error => this.specialiteSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.specialites, 'specialites');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.specialites);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}