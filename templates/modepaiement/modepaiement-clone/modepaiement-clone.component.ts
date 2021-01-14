
import { Component, OnInit } from '@angular/core';
import { ModepaiementService } from '../modepaiement.service';
import { Location } from '@angular/common';
import { Modepaiement } from '../modepaiement';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-modepaiement-clone',
  templateUrl: './modepaiement-clone.component.html',
  styleUrls: ['./modepaiement-clone.component.scss']
})
export class ModepaiementCloneComponent implements OnInit {
  modepaiement: Modepaiement;
  original: Modepaiement;
  constructor(public modepaiementSrv: ModepaiementService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['modepaiement'];
    this.modepaiement = Object.assign({}, this.original);
    this.modepaiement.id = null;
  }

  cloneModepaiement() {
    console.log(this.modepaiement);
    this.modepaiementSrv.clone(this.original, this.modepaiement)
      .subscribe((data: any) => {
        this.router.navigate([this.modepaiementSrv.getRoutePrefix(), data.id]);
      }, error => this.modepaiementSrv.httpSrv.handleError(error));
  }

}
