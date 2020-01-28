
import { Component, OnInit } from '@angular/core';
import { SpecialiteService } from '../specialite.service';
import { Location } from '@angular/common';
import { Specialite } from '../specialite';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-specialite-clone',
  templateUrl: './specialite-clone.component.html',
  styleUrls: ['./specialite-clone.component.scss']
})
export class SpecialiteCloneComponent implements OnInit {
  specialite: Specialite;
  original: Specialite;
  constructor(public specialiteSrv: SpecialiteService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['specialite'];
    this.specialite = Object.assign({}, this.original);
    this.specialite.id = null;
  }

  cloneSpecialite() {
    console.log(this.specialite);
    this.specialiteSrv.clone(this.original, this.specialite)
      .subscribe((data: any) => {
        this.router.navigate([this.specialiteSrv.getRoutePrefix(), data.id]);
      }, error => this.specialiteSrv.httpSrv.handleError(error));
  }

}
