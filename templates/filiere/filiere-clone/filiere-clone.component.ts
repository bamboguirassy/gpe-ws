
import { Component, OnInit } from '@angular/core';
import { FiliereService } from '../filiere.service';
import { Location } from '@angular/common';
import { Filiere } from '../filiere';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-filiere-clone',
  templateUrl: './filiere-clone.component.html',
  styleUrls: ['./filiere-clone.component.scss']
})
export class FiliereCloneComponent implements OnInit {
  filiere: Filiere;
  original: Filiere;
  constructor(public filiereSrv: FiliereService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['filiere'];
    this.filiere = Object.assign({}, this.original);
    this.filiere.id = null;
  }

  cloneFiliere() {
    console.log(this.filiere);
    this.filiereSrv.clone(this.original, this.filiere)
      .subscribe((data: any) => {
        this.router.navigate([this.filiereSrv.getRoutePrefix(), data.id]);
      }, error => this.filiereSrv.httpSrv.handleError(error));
  }

}
