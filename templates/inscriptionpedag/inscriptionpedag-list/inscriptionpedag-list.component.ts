import { Component, OnInit } from '@angular/core';
import { Inscriptionpedag } from '../user';
import { ActivatedRoute, Router } from '@angular/router';
import { InscriptionpedagService } from '../user.service';
import { inscriptionpedagColumns, allowedInscriptionpedagFieldsForFilter } from '../user.columns';
import { ExportService } from 'src/app/shared/services/export.service';
import { MenuItem } from 'primeng/api';
import { AuthService } from 'src/app/shared/services/auth.service';
import { NotificationService } from 'src/app/shared/services/notification.service';


@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class InscriptionpedagListComponent implements OnInit {

  inscriptionpedags: Inscriptionpedag[] = [];
  selectedInscriptionpedags: Inscriptionpedag[];
  selectedInscriptionpedag: Inscriptionpedag;
  clonedInscriptionpedags: Inscriptionpedag[];

  cMenuItems: MenuItem[]=[];

  tableColumns = inscriptionpedagColumns;
  //allowed fields for filter
  globalFilterFields = allowedInscriptionpedagFieldsForFilter;


  constructor(private activatedRoute: ActivatedRoute,
    public inscriptionpedagSrv: InscriptionpedagService, public exportSrv: ExportService,
    private router: Router, public authSrv: AuthService,
    public notificationSrv: NotificationService) { }

  ngOnInit() {
    if(this.authSrv.checkShowAccess('Inscriptionpedag')){
      this.cMenuItems.push({ label: 'Afficher détails', icon: 'pi pi-eye', command: (event) => this.viewInscriptionpedag(this.selectedInscriptionpedag) });
    }
    if(this.authSrv.checkEditAccess('Inscriptionpedag')){
      this.cMenuItems.push({ label: 'Modifier', icon: 'pi pi-pencil', command: (event) => this.editInscriptionpedag(this.selectedInscriptionpedag) })
    }
    if(this.authSrv.checkCloneAccess('Inscriptionpedag')){
      this.cMenuItems.push({ label: 'Cloner', icon: 'pi pi-clone', command: (event) => this.cloneInscriptionpedag(this.selectedInscriptionpedag) })
    }
    if(this.authSrv.checkDeleteAccess('Inscriptionpedag')){
      this.cMenuItems.push({ label: 'Supprimer', icon: 'pi pi-times', command: (event) => this.deleteInscriptionpedag(this.selectedInscriptionpedag) })
    }

    this.inscriptionpedags = this.activatedRoute.snapshot.data['inscriptionpedags'];
  }

  viewInscriptionpedag(inscriptionpedag: Inscriptionpedag) {
      this.router.navigate([this.inscriptionpedagSrv.getRoutePrefix(), inscriptionpedag.id]);

  }

  editInscriptionpedag(inscriptionpedag: Inscriptionpedag) {
      this.router.navigate([this.inscriptionpedagSrv.getRoutePrefix(), inscriptionpedag.id, 'edit']);
  }

  cloneInscriptionpedag(inscriptionpedag: Inscriptionpedag) {
      this.router.navigate([this.inscriptionpedagSrv.getRoutePrefix(), inscriptionpedag.id, 'clone']);
  }

  deleteInscriptionpedag(inscriptionpedag: Inscriptionpedag) {
      this.inscriptionpedagSrv.remove(inscriptionpedag)
        .subscribe(data => this.refreshList(), error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

  deleteSelectedInscriptionpedags(inscriptionpedag: Inscriptionpedag) {
    this.inscriptionpedagSrv.removeSelection(this.selectedInscriptionpedags)
      .subscribe(data => this.refreshList(), error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

  refreshList() {
    this.inscriptionpedagSrv.findAll()
      .subscribe((data: any) => this.inscriptionpedags = data, error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

  exportPdf() {
    this.exportSrv.exportPdf(this.tableColumns, this.inscriptionpedags, 'inscriptionpedags');
  }

  exportExcel() {
    this.exportSrv.exportExcel(this.inscriptionpedags);
  }

  saveAsExcelFile(buffer: any, fileName: string): void {
    this.exportSrv.saveAsExcelFile(buffer, fileName);
  }

}