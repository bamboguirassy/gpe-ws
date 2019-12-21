
import { Component, OnInit } from '@angular/core';
import { FosUserService } from '../fos_user.service';
import { Location } from '@angular/common';
import { FosUser } from '../fos_user';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-fos_user-clone',
  templateUrl: './fos_user-clone.component.html',
  styleUrls: ['./fos_user-clone.component.scss']
})
export class FosUserCloneComponent implements OnInit {
  fos_user: FosUser;
  original: FosUser;
  constructor(public fos_userSrv: FosUserService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['fos_user'];
    this.fos_user = Object.assign({}, this.original);
    this.fos_user.id = null;
  }

  cloneFosUser() {
    console.log(this.fos_user);
    this.fos_userSrv.clone(this.original, this.fos_user)
      .subscribe((data: any) => {
        this.router.navigate([this.fos_userSrv.getRoutePrefix(), data.id]);
      }, error => this.fos_userSrv.httpSrv.handleError(error));
  }

}
