import { Component, OnInit } from '@angular/core';
import { BourseEtudiant } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { BourseEtudiantService } from '../user.service';
import { bourse_etudiantColumns, allowedBourseEtudiantFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class BourseEtudiantListComponent implements OnInit {

  bourse_etudiants: BourseEtudiant[] = [];
  selectedBourseEtudiants: BourseEtudiant[];
  selectedBourseEtudiant: BourseEtudiant;
  clonedBourseEtudiants: BourseEtudiant[];

  cMenuItems: MenuItem[]=[];

  tableColumns = bourse_etudiantColumns;
  //allowed fields for filter
  globalFilterFields = allowedBourseEtudiantFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public bourse_etudiantSrv: BourseEtudiantService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('BourseEtudiant')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewBourseEtudiant(this.selectedBourseEtudiant) });
    }
    if(this.authSrv.checkEditAccess('BourseEtudiant')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editBourseEtudiant(this.selectedBourseEtudiant) })
    }
    if(this.authSrv.checkCloneAccess('BourseEtudiant')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneBourseEtudiant(this.selectedBourseEtudiant) })
    }
    if(this.authSrv.checkDeleteAccess('BourseEtudiant')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteBourseEtudiant(this.selectedBourseEtudiant) })
    }

    this.bourse_etudiants = this.activatedRoute.snapshot.data['bourse_etudiants'];
  }

  viewBourseEtudiant(bourse_etudiant: BourseEtudiant) {
      this.router.navigate([this.bourse_etudiantSrv.getRoutePrefix(), bourse_etudiant.id]);

  }

  editBourseEtudiant(bourse_etudiant: BourseEtudiant) {
      this.router.navigate([this.bourse_etudiantSrv.getRoutePrefix(), bourse_etudiant.id, 'edit']);
  }

  cloneBourseEtudiant(bourse_etudiant: BourseEtudiant) {
      this.router.navigate([this.bourse_etudiantSrv.getRoutePrefix(), bourse_etudiant.id, 'clone']);
  }

  deleteBourseEtudiant(bourse_etudiant: BourseEtudiant) {
      this.bourse_etudiantSrv.remove(bourse_etudiant)
        .subscribe(data => this.refreshList(), error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

  deleteSelectedBourseEtudiants(bourse_etudiant: BourseEtudiant) {
    this.bourse_etudiantSrv.removeSelection(this.selectedBourseEtudiants)
      .subscribe(data => this.refreshList(), error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.bourse_etudiantSrv.findAll()
      .subscribe((data: any) => this.bourse_etudiants = data, error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.bourse_etudiants, 'bourse_etudiants');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.bourse_etudiants);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}