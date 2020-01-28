import { Component, OnInit } from '@angular/core';
import { Regimeinscription } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { RegimeinscriptionService } from '../user.service';
import { regimeinscriptionColumns, allowedRegimeinscriptionFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class RegimeinscriptionListComponent implements OnInit {

  regimeinscriptions: Regimeinscription[] = [];
  selectedRegimeinscriptions: Regimeinscription[];
  selectedRegimeinscription: Regimeinscription;
  clonedRegimeinscriptions: Regimeinscription[];

  cMenuItems: MenuItem[]=[];

  tableColumns = regimeinscriptionColumns;
  //allowed fields for filter
  globalFilterFields = allowedRegimeinscriptionFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public regimeinscriptionSrv: RegimeinscriptionService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Regimeinscription')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewRegimeinscription(this.selectedRegimeinscription) });
    }
    if(this.authSrv.checkEditAccess('Regimeinscription')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editRegimeinscription(this.selectedRegimeinscription) })
    }
    if(this.authSrv.checkCloneAccess('Regimeinscription')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneRegimeinscription(this.selectedRegimeinscription) })
    }
    if(this.authSrv.checkDeleteAccess('Regimeinscription')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteRegimeinscription(this.selectedRegimeinscription) })
    }

    this.regimeinscriptions = this.activatedRoute.snapshot.data['regimeinscriptions'];
  }

  viewRegimeinscription(regimeinscription: Regimeinscription) {
      this.router.navigate([this.regimeinscriptionSrv.getRoutePrefix(), regimeinscription.id]);

  }

  editRegimeinscription(regimeinscription: Regimeinscription) {
      this.router.navigate([this.regimeinscriptionSrv.getRoutePrefix(), regimeinscription.id, 'edit']);
  }

  cloneRegimeinscription(regimeinscription: Regimeinscription) {
      this.router.navigate([this.regimeinscriptionSrv.getRoutePrefix(), regimeinscription.id, 'clone']);
  }

  deleteRegimeinscription(regimeinscription: Regimeinscription) {
      this.regimeinscriptionSrv.remove(regimeinscription)
        .subscribe(data => this.refreshList(), error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

  deleteSelectedRegimeinscriptions(regimeinscription: Regimeinscription) {
    this.regimeinscriptionSrv.removeSelection(this.selectedRegimeinscriptions)
      .subscribe(data => this.refreshList(), error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.regimeinscriptionSrv.findAll()
      .subscribe((data: any) => this.regimeinscriptions = data, error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.regimeinscriptions, 'regimeinscriptions');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.regimeinscriptions);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}