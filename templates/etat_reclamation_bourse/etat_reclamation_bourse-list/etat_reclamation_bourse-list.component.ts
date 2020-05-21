import { Component, OnInit } from '@angular/core';
import { EtatReclamationBourse } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { EtatReclamationBourseService } from '../user.service';
import { etat_reclamation_bourseColumns, allowedEtatReclamationBourseFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class EtatReclamationBourseListComponent implements OnInit {

  etat_reclamation_bourses: EtatReclamationBourse[] = [];
  selectedEtatReclamationBourses: EtatReclamationBourse[];
  selectedEtatReclamationBourse: EtatReclamationBourse;
  clonedEtatReclamationBourses: EtatReclamationBourse[];

  cMenuItems: MenuItem[]=[];

  tableColumns = etat_reclamation_bourseColumns;
  //allowed fields for filter
  globalFilterFields = allowedEtatReclamationBourseFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public etat_reclamation_bourseSrv: EtatReclamationBourseService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('EtatReclamationBourse')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewEtatReclamationBourse(this.selectedEtatReclamationBourse) });
    }
    if(this.authSrv.checkEditAccess('EtatReclamationBourse')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editEtatReclamationBourse(this.selectedEtatReclamationBourse) })
    }
    if(this.authSrv.checkCloneAccess('EtatReclamationBourse')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneEtatReclamationBourse(this.selectedEtatReclamationBourse) })
    }
    if(this.authSrv.checkDeleteAccess('EtatReclamationBourse')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteEtatReclamationBourse(this.selectedEtatReclamationBourse) })
    }

    this.etat_reclamation_bourses = this.activatedRoute.snapshot.data['etat_reclamation_bourses'];
  }

  viewEtatReclamationBourse(etat_reclamation_bourse: EtatReclamationBourse) {
      this.router.navigate([this.etat_reclamation_bourseSrv.getRoutePrefix(), etat_reclamation_bourse.id]);

  }

  editEtatReclamationBourse(etat_reclamation_bourse: EtatReclamationBourse) {
      this.router.navigate([this.etat_reclamation_bourseSrv.getRoutePrefix(), etat_reclamation_bourse.id, 'edit']);
  }

  cloneEtatReclamationBourse(etat_reclamation_bourse: EtatReclamationBourse) {
      this.router.navigate([this.etat_reclamation_bourseSrv.getRoutePrefix(), etat_reclamation_bourse.id, 'clone']);
  }

  deleteEtatReclamationBourse(etat_reclamation_bourse: EtatReclamationBourse) {
      this.etat_reclamation_bourseSrv.remove(etat_reclamation_bourse)
        .subscribe(data => this.refreshList(), error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

  deleteSelectedEtatReclamationBourses(etat_reclamation_bourse: EtatReclamationBourse) {
    this.etat_reclamation_bourseSrv.removeSelection(this.selectedEtatReclamationBourses)
      .subscribe(data => this.refreshList(), error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.etat_reclamation_bourseSrv.findAll()
      .subscribe((data: any) => this.etat_reclamation_bourses = data, error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.etat_reclamation_bourses, 'etat_reclamation_bourses');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.etat_reclamation_bourses);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}