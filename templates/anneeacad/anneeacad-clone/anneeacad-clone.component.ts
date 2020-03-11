
import { Component, OnInit } from '@angular/core';
import { AnneeacadService } from '../anneeacad.service';
import { Location } from '@angular/common';
import { Anneeacad } from '../anneeacad';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-anneeacad-clone',
  templateUrl: './anneeacad-clone.component.html',
  styleUrls: ['./anneeacad-clone.component.scss']
})
export class AnneeacadCloneComponent implements OnInit {
  anneeacad: Anneeacad;
  original: Anneeacad;
  constructor(public anneeacadSrv: AnneeacadService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['anneeacad'];
    this.anneeacad = Object.assign({}, this.original);
    this.anneeacad.id = null;
  }

  cloneAnneeacad() {
    console.log(this.anneeacad);
    this.anneeacadSrv.clone(this.original, this.anneeacad)
      .subscribe((data: any) => {
        this.router.navigate([this.anneeacadSrv.getRoutePrefix(), data.id]);
      }, error => this.anneeacadSrv.httpSrv.handleError(error));
  }

}
