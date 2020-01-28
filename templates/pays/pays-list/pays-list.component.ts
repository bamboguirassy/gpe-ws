import { Component, OnInit } from '@angular/core';
import { Pays } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { PaysService } from '../user.service';
import { payColumns, allowedPaysFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class PaysListComponent implements OnInit {

  pays: Pays[] = [];
  selectedPayss: Pays[];
  selectedPays: Pays;
  clonedPayss: Pays[];

  cMenuItems: MenuItem[]=[];

  tableColumns = payColumns;
  //allowed fields for filter
  globalFilterFields = allowedPaysFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public paySrv: PaysService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Pays')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewPays(this.selectedPays) });
    }
    if(this.authSrv.checkEditAccess('Pays')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editPays(this.selectedPays) })
    }
    if(this.authSrv.checkCloneAccess('Pays')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.clonePays(this.selectedPays) })
    }
    if(this.authSrv.checkDeleteAccess('Pays')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deletePays(this.selectedPays) })
    }

    this.pays = this.activatedRoute.snapshot.data['pays'];
  }

  viewPays(pay: Pays) {
      this.router.navigate([this.paySrv.getRoutePrefix(), pay.id]);

  }

  editPays(pay: Pays) {
      this.router.navigate([this.paySrv.getRoutePrefix(), pay.id, 'edit']);
  }

  clonePays(pay: Pays) {
      this.router.navigate([this.paySrv.getRoutePrefix(), pay.id, 'clone']);
  }

  deletePays(pay: Pays) {
      this.paySrv.remove(pay)
        .subscribe(data => this.refreshList(), error => this.paySrv.httpSrv.handleError(error));
  }

  deleteSelectedPayss(pay: Pays) {
    this.paySrv.removeSelection(this.selectedPayss)
      .subscribe(data => this.refreshList(), error => this.paySrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.paySrv.findAll()
      .subscribe((data: any) => this.pays = data, error => this.paySrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.pays, 'pays');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.pays);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}