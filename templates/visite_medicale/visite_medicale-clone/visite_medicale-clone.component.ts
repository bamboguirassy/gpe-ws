
import { Component, OnInit } from '@angular/core';
import { VisiteMedicaleService } from '../visitemedicale.service';
import { Location } from '@angular/common';
import { VisiteMedicale } from '../visitemedicale';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-visitemedicale-clone',
  templateUrl: './visitemedicale-clone.component.html',
  styleUrls: ['./visitemedicale-clone.component.scss']
})
export class VisiteMedicaleCloneComponent implements OnInit {
  visiteMedicale: VisiteMedicale;
  original: VisiteMedicale;
  constructor(public visiteMedicaleSrv: VisiteMedicaleService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['visiteMedicale'];
    this.visiteMedicale = Object.assign({}, this.original);
    this.visiteMedicale.id = null;
  }

  cloneVisiteMedicale() {
    console.log(this.visiteMedicale);
    this.visiteMedicaleSrv.clone(this.original, this.visiteMedicale)
      .subscribe((data: any) => {
        this.router.navigate([this.visiteMedicaleSrv.getRoutePrefix(), data.id]);
      }, error => this.visiteMedicaleSrv.httpSrv.handleError(error));
  }

}
