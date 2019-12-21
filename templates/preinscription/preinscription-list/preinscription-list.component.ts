import { Component, OnInit } from '@angular/core';
import { Preinscription } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { PreinscriptionService } from '../user.service';
import { preinscriptionColumns, allowedPreinscriptionFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class PreinscriptionListComponent implements OnInit {

  preinscriptions: Preinscription[] = [];
  selectedPreinscriptions: Preinscription[];
  selectedPreinscription: Preinscription;
  clonedPreinscriptions: Preinscription[];

  cMenuItems: MenuItem[]=[];

  tableColumns = preinscriptionColumns;
  //allowed fields for filter
  globalFilterFields = allowedPreinscriptionFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public preinscriptionSrv: PreinscriptionService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Preinscription')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewPreinscription(this.selectedPreinscription) });
    }
    if(this.authSrv.checkEditAccess('Preinscription')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editPreinscription(this.selectedPreinscription) })
    }
    if(this.authSrv.checkCloneAccess('Preinscription')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.clonePreinscription(this.selectedPreinscription) })
    }
    if(this.authSrv.checkDeleteAccess('Preinscription')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deletePreinscription(this.selectedPreinscription) })
    }

    this.preinscriptions = this.activatedRoute.snapshot.data['preinscriptions'];
  }

  viewPreinscription(preinscription: Preinscription) {
      this.router.navigate([this.preinscriptionSrv.getRoutePrefix(), preinscription.id]);

  }

  editPreinscription(preinscription: Preinscription) {
      this.router.navigate([this.preinscriptionSrv.getRoutePrefix(), preinscription.id, 'edit']);
  }

  clonePreinscription(preinscription: Preinscription) {
      this.router.navigate([this.preinscriptionSrv.getRoutePrefix(), preinscription.id, 'clone']);
  }

  deletePreinscription(preinscription: Preinscription) {
      this.preinscriptionSrv.remove(preinscription)
        .subscribe(data => this.refreshList(), error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

  deleteSelectedPreinscriptions(preinscription: Preinscription) {
    this.preinscriptionSrv.removeSelection(this.selectedPreinscriptions)
      .subscribe(data => this.refreshList(), error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.preinscriptionSrv.findAll()
      .subscribe((data: any) => this.preinscriptions = data, error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.preinscriptions, 'preinscriptions');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.preinscriptions);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}