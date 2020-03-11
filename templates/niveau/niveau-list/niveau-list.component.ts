import { Component, OnInit } from '@angular/core';
import { Niveau } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { NiveauService } from '../user.service';
import { niveauColumns, allowedNiveauFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class NiveauListComponent implements OnInit {

  niveaus: Niveau[] = [];
  selectedNiveaus: Niveau[];
  selectedNiveau: Niveau;
  clonedNiveaus: Niveau[];

  cMenuItems: MenuItem[]=[];

  tableColumns = niveauColumns;
  //allowed fields for filter
  globalFilterFields = allowedNiveauFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public niveauSrv: NiveauService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Niveau')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewNiveau(this.selectedNiveau) });
    }
    if(this.authSrv.checkEditAccess('Niveau')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editNiveau(this.selectedNiveau) })
    }
    if(this.authSrv.checkCloneAccess('Niveau')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneNiveau(this.selectedNiveau) })
    }
    if(this.authSrv.checkDeleteAccess('Niveau')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteNiveau(this.selectedNiveau) })
    }

    this.niveaus = this.activatedRoute.snapshot.data['niveaus'];
  }

  viewNiveau(niveau: Niveau) {
      this.router.navigate([this.niveauSrv.getRoutePrefix(), niveau.id]);

  }

  editNiveau(niveau: Niveau) {
      this.router.navigate([this.niveauSrv.getRoutePrefix(), niveau.id, 'edit']);
  }

  cloneNiveau(niveau: Niveau) {
      this.router.navigate([this.niveauSrv.getRoutePrefix(), niveau.id, 'clone']);
  }

  deleteNiveau(niveau: Niveau) {
      this.niveauSrv.remove(niveau)
        .subscribe(data => this.refreshList(), error => this.niveauSrv.httpSrv.handleError(error));
  }

  deleteSelectedNiveaus(niveau: Niveau) {
    this.niveauSrv.removeSelection(this.selectedNiveaus)
      .subscribe(data => this.refreshList(), error => this.niveauSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.niveauSrv.findAll()
      .subscribe((data: any) => this.niveaus = data, error => this.niveauSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.niveaus, 'niveaus');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.niveaus);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}