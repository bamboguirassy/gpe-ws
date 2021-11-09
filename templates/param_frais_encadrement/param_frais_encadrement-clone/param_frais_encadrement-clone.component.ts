
import { Component, OnInit } from '@angular/core';
import { ParamFraisEncadrementService } from '../paramfraisencadrement.service';
import { Location } from '@angular/common';
import { ParamFraisEncadrement } from '../paramfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-paramfraisencadrement-clone',
  templateUrl: './paramfraisencadrement-clone.component.html',
  styleUrls: ['./paramfraisencadrement-clone.component.scss']
})
export class ParamFraisEncadrementCloneComponent implements OnInit {
  paramFraisEncadrement: ParamFraisEncadrement;
  original: ParamFraisEncadrement;
  constructor(public paramFraisEncadrementSrv: ParamFraisEncadrementService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['paramFraisEncadrement'];
    this.paramFraisEncadrement = Object.assign({}, this.original);
    this.paramFraisEncadrement.id = null;
  }

  cloneParamFraisEncadrement() {
    console.log(this.paramFraisEncadrement);
    this.paramFraisEncadrementSrv.clone(this.original, this.paramFraisEncadrement)
      .subscribe((data: any) => {
        this.router.navigate([this.paramFraisEncadrementSrv.getRoutePrefix(), data.id]);
      }, error => this.paramFraisEncadrementSrv.httpSrv.handleError(error));
  }

}
