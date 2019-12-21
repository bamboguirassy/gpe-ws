import { Component, OnInit } from '@angular/core';
import { FosUser } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { FosUserService } from '../user.service';
import { fos_userColumns, allowedFosUserFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class FosUserListComponent implements OnInit {

  fos_users: FosUser[] = [];
  selectedFosUsers: FosUser[];
  selectedFosUser: FosUser;
  clonedFosUsers: FosUser[];

  cMenuItems: MenuItem[]=[];

  tableColumns = fos_userColumns;
  //allowed fields for filter
  globalFilterFields = allowedFosUserFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public fos_userSrv: FosUserService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('FosUser')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewFosUser(this.selectedFosUser) });
    }
    if(this.authSrv.checkEditAccess('FosUser')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editFosUser(this.selectedFosUser) })
    }
    if(this.authSrv.checkCloneAccess('FosUser')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneFosUser(this.selectedFosUser) })
    }
    if(this.authSrv.checkDeleteAccess('FosUser')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteFosUser(this.selectedFosUser) })
    }

    this.fos_users = this.activatedRoute.snapshot.data['fos_users'];
  }

  viewFosUser(fos_user: FosUser) {
      this.router.navigate([this.fos_userSrv.getRoutePrefix(), fos_user.id]);

  }

  editFosUser(fos_user: FosUser) {
      this.router.navigate([this.fos_userSrv.getRoutePrefix(), fos_user.id, 'edit']);
  }

  cloneFosUser(fos_user: FosUser) {
      this.router.navigate([this.fos_userSrv.getRoutePrefix(), fos_user.id, 'clone']);
  }

  deleteFosUser(fos_user: FosUser) {
      this.fos_userSrv.remove(fos_user)
        .subscribe(data => this.refreshList(), error => this.fos_userSrv.httpSrv.handleError(error));
  }

  deleteSelectedFosUsers(fos_user: FosUser) {
    this.fos_userSrv.removeSelection(this.selectedFosUsers)
      .subscribe(data => this.refreshList(), error => this.fos_userSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.fos_userSrv.findAll()
      .subscribe((data: any) => this.fos_users = data, error => this.fos_userSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.fos_users, 'fos_users');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.fos_users);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}