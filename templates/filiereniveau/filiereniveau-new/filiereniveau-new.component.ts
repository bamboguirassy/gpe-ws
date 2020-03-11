import { Component, OnInit } from '@angular/core';
import { Filiereniveau } from '../filiereniveau';
import { FiliereniveauService } from '../filiereniveau.service';
import { NotificationService } from 'src/app/shared/services/notification.service';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-filiereniveau-new',
  templateUrl: './filiereniveau-new.component.html',
  styleUrls: ['./filiereniveau-new.component.scss']
})
export class FiliereniveauNewComponent implements OnInit {
  filiereniveau: Filiereniveau;
  constructor(public filiereniveauSrv: FiliereniveauService,
    public notificationSrv: NotificationService,
    public router: Router, public location: Location) {
    this.filiereniveau = new Filiereniveau();
  }

  ngOnInit() {
  }

  saveFiliereniveau() {
    this.filiereniveauSrv.create(this.filiereniveau)
      .subscribe((data: any) => {
        this.notificationSrv.showInfo('Filiereniveau créé avec succès');
        this.filiereniveau = new Filiereniveau();
      }, error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

  saveFiliereniveauAndExit() {
    this.filiereniveauSrv.create(this.filiereniveau)
      .subscribe((data: any) => {
        this.router.navigate([this.filiereniveauSrv.getRoutePrefix(), data.id]);
      }, error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

}

