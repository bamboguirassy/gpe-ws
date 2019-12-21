import { Component, OnInit } from '@angular/core';
import { Inscriptionacad } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { InscriptionacadService } from '../user.service';
import { inscriptionacadColumns, allowedInscriptionacadFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class InscriptionacadListComponent implements OnInit {

  inscriptionacads: Inscriptionacad[] = [];
  selectedInscriptionacads: Inscriptionacad[];
  selectedInscriptionacad: Inscriptionacad;
  clonedInscriptionacads: Inscriptionacad[];

  cMenuItems: MenuItem[]=[];

  tableColumns = inscriptionacadColumns;
  //allowed fields for filter
  globalFilterFields = allowedInscriptionacadFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public inscriptionacadSrv: InscriptionacadService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Inscriptionacad')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewInscriptionacad(this.selectedInscriptionacad) });
    }
    if(this.authSrv.checkEditAccess('Inscriptionacad')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editInscriptionacad(this.selectedInscriptionacad) })
    }
    if(this.authSrv.checkCloneAccess('Inscriptionacad')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneInscriptionacad(this.selectedInscriptionacad) })
    }
    if(this.authSrv.checkDeleteAccess('Inscriptionacad')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteInscriptionacad(this.selectedInscriptionacad) })
    }

    this.inscriptionacads = this.activatedRoute.snapshot.data['inscriptionacads'];
  }

  viewInscriptionacad(inscriptionacad: Inscriptionacad) {
      this.router.navigate([this.inscriptionacadSrv.getRoutePrefix(), inscriptionacad.id]);

  }

  editInscriptionacad(inscriptionacad: Inscriptionacad) {
      this.router.navigate([this.inscriptionacadSrv.getRoutePrefix(), inscriptionacad.id, 'edit']);
  }

  cloneInscriptionacad(inscriptionacad: Inscriptionacad) {
      this.router.navigate([this.inscriptionacadSrv.getRoutePrefix(), inscriptionacad.id, 'clone']);
  }

  deleteInscriptionacad(inscriptionacad: Inscriptionacad) {
      this.inscriptionacadSrv.remove(inscriptionacad)
        .subscribe(data => this.refreshList(), error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

  deleteSelectedInscriptionacads(inscriptionacad: Inscriptionacad) {
    this.inscriptionacadSrv.removeSelection(this.selectedInscriptionacads)
      .subscribe(data => this.refreshList(), error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.inscriptionacadSrv.findAll()
      .subscribe((data: any) => this.inscriptionacads = data, error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.inscriptionacads, 'inscriptionacads');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.inscriptionacads);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}