
import { Component, OnInit } from '@angular/core';
import { InscriptionpedagService } from '../inscriptionpedag.service';
import { Location } from '@angular/common';
import { Inscriptionpedag } from '../inscriptionpedag';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-inscriptionpedag-clone',
  templateUrl: './inscriptionpedag-clone.component.html',
  styleUrls: ['./inscriptionpedag-clone.component.scss']
})
export class InscriptionpedagCloneComponent implements OnInit {
  inscriptionpedag: Inscriptionpedag;
  original: Inscriptionpedag;
  constructor(public inscriptionpedagSrv: InscriptionpedagService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['inscriptionpedag'];
    this.inscriptionpedag = Object.assign({}, this.original);
    this.inscriptionpedag.id = null;
  }

  cloneInscriptionpedag() {
    console.log(this.inscriptionpedag);
    this.inscriptionpedagSrv.clone(this.original, this.inscriptionpedag)
      .subscribe((data: any) => {
        this.router.navigate([this.inscriptionpedagSrv.getRoutePrefix(), data.id]);
      }, error => this.inscriptionpedagSrv.httpSrv.handleError(error));
  }

}
