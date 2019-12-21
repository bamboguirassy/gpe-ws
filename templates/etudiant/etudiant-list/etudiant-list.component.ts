import { Component, OnInit } from '@angular/core';
import { Etudiant } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { EtudiantService } from '../user.service';
import { etudiantColumns, allowedEtudiantFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class EtudiantListComponent implements OnInit {

  etudiants: Etudiant[] = [];
  selectedEtudiants: Etudiant[];
  selectedEtudiant: Etudiant;
  clonedEtudiants: Etudiant[];

  cMenuItems: MenuItem[]=[];

  tableColumns = etudiantColumns;
  //allowed fields for filter
  globalFilterFields = allowedEtudiantFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public etudiantSrv: EtudiantService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Etudiant')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewEtudiant(this.selectedEtudiant) });
    }
    if(this.authSrv.checkEditAccess('Etudiant')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editEtudiant(this.selectedEtudiant) })
    }
    if(this.authSrv.checkCloneAccess('Etudiant')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneEtudiant(this.selectedEtudiant) })
    }
    if(this.authSrv.checkDeleteAccess('Etudiant')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteEtudiant(this.selectedEtudiant) })
    }

    this.etudiants = this.activatedRoute.snapshot.data['etudiants'];
  }

  viewEtudiant(etudiant: Etudiant) {
      this.router.navigate([this.etudiantSrv.getRoutePrefix(), etudiant.id]);

  }

  editEtudiant(etudiant: Etudiant) {
      this.router.navigate([this.etudiantSrv.getRoutePrefix(), etudiant.id, 'edit']);
  }

  cloneEtudiant(etudiant: Etudiant) {
      this.router.navigate([this.etudiantSrv.getRoutePrefix(), etudiant.id, 'clone']);
  }

  deleteEtudiant(etudiant: Etudiant) {
      this.etudiantSrv.remove(etudiant)
        .subscribe(data => this.refreshList(), error => this.etudiantSrv.httpSrv.handleError(error));
  }

  deleteSelectedEtudiants(etudiant: Etudiant) {
    this.etudiantSrv.removeSelection(this.selectedEtudiants)
      .subscribe(data => this.refreshList(), error => this.etudiantSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.etudiantSrv.findAll()
      .subscribe((data: any) => this.etudiants = data, error => this.etudiantSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.etudiants, 'etudiants');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.etudiants);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}