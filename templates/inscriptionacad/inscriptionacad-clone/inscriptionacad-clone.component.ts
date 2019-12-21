
import { Component, OnInit } from '@angular/core';
import { InscriptionacadService } from '../inscriptionacad.service';
import { Location } from '@angular/common';
import { Inscriptionacad } from '../inscriptionacad';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-inscriptionacad-clone',
  templateUrl: './inscriptionacad-clone.component.html',
  styleUrls: ['./inscriptionacad-clone.component.scss']
})
export class InscriptionacadCloneComponent implements OnInit {
  inscriptionacad: Inscriptionacad;
  original: Inscriptionacad;
  constructor(public inscriptionacadSrv: InscriptionacadService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['inscriptionacad'];
    this.inscriptionacad = Object.assign({}, this.original);
    this.inscriptionacad.id = null;
  }

  cloneInscriptionacad() {
    console.log(this.inscriptionacad);
    this.inscriptionacadSrv.clone(this.original, this.inscriptionacad)
      .subscribe((data: any) => {
        this.router.navigate([this.inscriptionacadSrv.getRoutePrefix(), data.id]);
      }, error => this.inscriptionacadSrv.httpSrv.handleError(error));
  }

}
