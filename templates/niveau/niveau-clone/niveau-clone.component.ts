
import { Component, OnInit } from '@angular/core';
import { NiveauService } from '../niveau.service';
import { Location } from '@angular/common';
import { Niveau } from '../niveau';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-niveau-clone',
  templateUrl: './niveau-clone.component.html',
  styleUrls: ['./niveau-clone.component.scss']
})
export class NiveauCloneComponent implements OnInit {
  niveau: Niveau;
  original: Niveau;
  constructor(public niveauSrv: NiveauService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['niveau'];
    this.niveau = Object.assign({}, this.original);
    this.niveau.id = null;
  }

  cloneNiveau() {
    console.log(this.niveau);
    this.niveauSrv.clone(this.original, this.niveau)
      .subscribe((data: any) => {
        this.router.navigate([this.niveauSrv.getRoutePrefix(), data.id]);
      }, error => this.niveauSrv.httpSrv.handleError(error));
  }

}
