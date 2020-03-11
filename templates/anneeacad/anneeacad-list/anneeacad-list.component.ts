import { Component, OnInit } from '@angular/core';
import { Anneeacad } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { AnneeacadService } from '../user.service';
import { anneeacadColumns, allowedAnneeacadFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class AnneeacadListComponent implements OnInit {

  anneeacads: Anneeacad[] = [];
  selectedAnneeacads: Anneeacad[];
  selectedAnneeacad: Anneeacad;
  clonedAnneeacads: Anneeacad[];

  cMenuItems: MenuItem[]=[];

  tableColumns = anneeacadColumns;
  //allowed fields for filter
  globalFilterFields = allowedAnneeacadFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public anneeacadSrv: AnneeacadService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Anneeacad')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewAnneeacad(this.selectedAnneeacad) });
    }
    if(this.authSrv.checkEditAccess('Anneeacad')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editAnneeacad(this.selectedAnneeacad) })
    }
    if(this.authSrv.checkCloneAccess('Anneeacad')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneAnneeacad(this.selectedAnneeacad) })
    }
    if(this.authSrv.checkDeleteAccess('Anneeacad')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteAnneeacad(this.selectedAnneeacad) })
    }

    this.anneeacads = this.activatedRoute.snapshot.data['anneeacads'];
  }

  viewAnneeacad(anneeacad: Anneeacad) {
      this.router.navigate([this.anneeacadSrv.getRoutePrefix(), anneeacad.id]);

  }

  editAnneeacad(anneeacad: Anneeacad) {
      this.router.navigate([this.anneeacadSrv.getRoutePrefix(), anneeacad.id, 'edit']);
  }

  cloneAnneeacad(anneeacad: Anneeacad) {
      this.router.navigate([this.anneeacadSrv.getRoutePrefix(), anneeacad.id, 'clone']);
  }

  deleteAnneeacad(anneeacad: Anneeacad) {
      this.anneeacadSrv.remove(anneeacad)
        .subscribe(data => this.refreshList(), error => this.anneeacadSrv.httpSrv.handleError(error));
  }

  deleteSelectedAnneeacads(anneeacad: Anneeacad) {
    this.anneeacadSrv.removeSelection(this.selectedAnneeacads)
      .subscribe(data => this.refreshList(), error => this.anneeacadSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.anneeacadSrv.findAll()
      .subscribe((data: any) => this.anneeacads = data, error => this.anneeacadSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.anneeacads, 'anneeacads');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.anneeacads);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}