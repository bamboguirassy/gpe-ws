import { Component, OnInit } from '@angular/core';
import { Filiereniveau } from '../filiereniveau';
import { ActivatedRoute, Router } from '@angular/router';
import { FiliereniveauService } from '../filiereniveau.service';
import { Location } from '@angular/common';
import { NotificationService } from 'src/app/shared/services/notification.service';

@Component({
  selector: 'app-filiereniveau-show',
  templateUrl: './filiereniveau-show.component.html',
  styleUrls: ['./filiereniveau-show.component.scss']
})
export class FiliereniveauShowComponent implements OnInit {

  filiereniveau: Filiereniveau;
  constructor(public activatedRoute: ActivatedRoute,
    public filiereniveauSrv: FiliereniveauService, public location: Location,
    public router: Router, public notificationSrv: NotificationService) {
  }

  ngOnInit() {
    this.filiereniveau = this.activatedRoute.snapshot.data['filiereniveau'];
  }

  removeFiliereniveau() {
    this.filiereniveauSrv.remove(this.filiereniveau)
      .subscribe(data => this.router.navigate([this.filiereniveauSrv.getRoutePrefix()]),
        error =>  this.filiereniveauSrv.httpSrv.handleError(error));
  }
  
  refresh(){
    this.filiereniveauSrv.findOneById(this.filiereniveau.id)
    .subscribe((data:any)=>this.filiereniveau=data,
      error=>this.filiereniveauSrv.httpSrv.handleError(error));
  }

}

