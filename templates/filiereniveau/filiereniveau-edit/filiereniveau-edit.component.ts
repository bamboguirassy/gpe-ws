
import { Component, OnInit } from '@angular/core';
import { FiliereniveauService } from '../filiereniveau.service';
import { Filiereniveau } from '../filiereniveau';
import { ActivatedRoute, Router } from '@angular/router';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-filiereniveau-edit',
  templateUrl: './filiereniveau-edit.component.html',
  styleUrls: ['./filiereniveau-edit.component.scss']
})
export class FiliereniveauEditComponent implements OnInit {

  filiereniveau: Filiereniveau;
  constructor(public filiereniveauSrv: FiliereniveauService,
    public activatedRoute: ActivatedRoute,
    public router: Router, public location: Location,
    public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.filiereniveau = this.activatedRoute.snapshot.data['filiereniveau'];
  }

  updateFiliereniveau() {
    this.filiereniveauSrv.update(this.filiereniveau)
      .subscribe(data => this.location.back(),
        error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

}
