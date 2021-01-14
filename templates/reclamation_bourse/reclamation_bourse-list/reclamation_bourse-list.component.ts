import { Component, OnInit } from '@angular/core';
import { ReclamationBourse } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { ReclamationBourseService } from '../user.service';
import { reclamation_bourseColumns, allowedReclamationBourseFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class ReclamationBourseListComponent implements OnInit {

  reclamation_bourses: ReclamationBourse[] = [];
  selectedReclamationBourses: ReclamationBourse[];
  selectedReclamationBourse: ReclamationBourse;
  clonedReclamationBourses: ReclamationBourse[];

  cMenuItems: MenuItem[]=[];

  tableColumns = reclamation_bourseColumns;
  //allowed fields for filter
  globalFilterFields = allowedReclamationBourseFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public reclamation_bourseSrv: ReclamationBourseService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('ReclamationBourse')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewReclamationBourse(this.selectedReclamationBourse) });
    }
    if(this.authSrv.checkEditAccess('ReclamationBourse')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editReclamationBourse(this.selectedReclamationBourse) })
    }
    if(this.authSrv.checkCloneAccess('ReclamationBourse')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneReclamationBourse(this.selectedReclamationBourse) })
    }
    if(this.authSrv.checkDeleteAccess('ReclamationBourse')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteReclamationBourse(this.selectedReclamationBourse) })
    }

    this.reclamation_bourses = this.activatedRoute.snapshot.data['reclamation_bourses'];
  }

  viewReclamationBourse(reclamation_bourse: ReclamationBourse) {
      this.router.navigate([this.reclamation_bourseSrv.getRoutePrefix(), reclamation_bourse.id]);

  }

  editReclamationBourse(reclamation_bourse: ReclamationBourse) {
      this.router.navigate([this.reclamation_bourseSrv.getRoutePrefix(), reclamation_bourse.id, 'edit']);
  }

  cloneReclamationBourse(reclamation_bourse: ReclamationBourse) {
      this.router.navigate([this.reclamation_bourseSrv.getRoutePrefix(), reclamation_bourse.id, 'clone']);
  }

  deleteReclamationBourse(reclamation_bourse: ReclamationBourse) {
      this.reclamation_bourseSrv.remove(reclamation_bourse)
        .subscribe(data => this.refreshList(), error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

  deleteSelectedReclamationBourses(reclamation_bourse: ReclamationBourse) {
    this.reclamation_bourseSrv.removeSelection(this.selectedReclamationBourses)
      .subscribe(data => this.refreshList(), error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.reclamation_bourseSrv.findAll()
      .subscribe((data: any) => this.reclamation_bourses = data, error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.reclamation_bourses, 'reclamation_bourses');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.reclamation_bourses);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}