import { Component, OnInit } from '@angular/core';
import { AssistanceEmail } from '../assistanceemail';
import { ActivatedRoute, Router } from '@angular/router';
import { AssistanceEmailService } from '../assistanceemail.service';
import { assistanceEmailColumns, allowedAssistanceEmailFieldsForFilter } from '../assistanceemail.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-assistanceemail-list',
  templateUrl: './assistanceemail-list.component.html',
  styleUrls: ['./assistanceemail-list.component.scss']
})
export class AssistanceEmailListComponent implements OnInit {

  assistanceEmails: AssistanceEmail[] = [];
  selectedAssistanceEmails: AssistanceEmail[];
  selectedAssistanceEmail: AssistanceEmail;
  clonedAssistanceEmails: AssistanceEmail[];

  cMenuItems: MenuItem[]=[];

  tableColumns = assistanceEmailColumns;
  //allowed fields for filter
  globalFilterFields = allowedAssistanceEmailFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public assistanceEmailSrv: AssistanceEmailService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('AssistanceEmail')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewAssistanceEmail(this.selectedAssistanceEmail) });
    }
    if(this.authSrv.checkEditAccess('AssistanceEmail')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editAssistanceEmail(this.selectedAssistanceEmail) })
    }
    if(this.authSrv.checkCloneAccess('AssistanceEmail')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneAssistanceEmail(this.selectedAssistanceEmail) })
    }
    if(this.authSrv.checkDeleteAccess('AssistanceEmail')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteAssistanceEmail(this.selectedAssistanceEmail) })
    }

    this.assistanceEmails = this.activatedRoute.snapshot.data['assistanceEmails'];
  }

  viewAssistanceEmail(assistanceEmail: AssistanceEmail) {
      this.router.navigate([this.assistanceEmailSrv.getRoutePrefix(), assistanceEmail.id]);

  }

  editAssistanceEmail(assistanceEmail: AssistanceEmail) {
      this.router.navigate([this.assistanceEmailSrv.getRoutePrefix(), assistanceEmail.id, 'edit']);
  }

  cloneAssistanceEmail(assistanceEmail: AssistanceEmail) {
      this.router.navigate([this.assistanceEmailSrv.getRoutePrefix(), assistanceEmail.id, 'clone']);
  }

  deleteAssistanceEmail(assistanceEmail: AssistanceEmail) {
      this.assistanceEmailSrv.remove(assistanceEmail)
        .subscribe(data => this.refreshList(), error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

  deleteSelectedAssistanceEmails(assistanceEmail: AssistanceEmail) {
    this.assistanceEmailSrv.removeSelection(this.selectedAssistanceEmails)
      .subscribe(data => this.refreshList(), error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.assistanceEmailSrv.findAll()
      .subscribe((data: any) => this.assistanceEmails = data, error => this.assistanceEmailSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.assistanceEmails, 'assistanceEmails');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.assistanceEmails);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}