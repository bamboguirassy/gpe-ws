
import { Component, OnInit } from '@angular/core';
import { PaiementFraisEncadrementService } from '../paiementfraisencadrement.service';
import { Location } from '@angular/common';
import { PaiementFraisEncadrement } from '../paiementfraisencadrement';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-paiementfraisencadrement-clone',
  templateUrl: './paiementfraisencadrement-clone.component.html',
  styleUrls: ['./paiementfraisencadrement-clone.component.scss']
})
export class PaiementFraisEncadrementCloneComponent implements OnInit {
  paiementFraisEncadrement: PaiementFraisEncadrement;
  original: PaiementFraisEncadrement;
  constructor(public paiementFraisEncadrementSrv: PaiementFraisEncadrementService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['paiementFraisEncadrement'];
    this.paiementFraisEncadrement = Object.assign({}, this.original);
    this.paiementFraisEncadrement.id = null;
  }

  clonePaiementFraisEncadrement() {
    console.log(this.paiementFraisEncadrement);
    this.paiementFraisEncadrementSrv.clone(this.original, this.paiementFraisEncadrement)
      .subscribe((data: any) => {
        this.router.navigate([this.paiementFraisEncadrementSrv.getRoutePrefix(), data.id]);
      }, error => this.paiementFraisEncadrementSrv.httpSrv.handleError(error));
  }

}
