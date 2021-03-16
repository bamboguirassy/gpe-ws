
import { Component, OnInit } from '@angular/core';
import { InscriptionTemporaireService } from '../inscriptiontemporaire.service';
import { Location } from '@angular/common';
import { InscriptionTemporaire } from '../inscriptiontemporaire';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-inscriptiontemporaire-clone',
  templateUrl: './inscriptiontemporaire-clone.component.html',
  styleUrls: ['./inscriptiontemporaire-clone.component.scss']
})
export class InscriptionTemporaireCloneComponent implements OnInit {
  inscriptionTemporaire: InscriptionTemporaire;
  original: InscriptionTemporaire;
  constructor(public inscriptionTemporaireSrv: InscriptionTemporaireService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['inscriptionTemporaire'];
    this.inscriptionTemporaire = Object.assign({}, this.original);
    this.inscriptionTemporaire.id = null;
  }

  cloneInscriptionTemporaire() {
    console.log(this.inscriptionTemporaire);
    this.inscriptionTemporaireSrv.clone(this.original, this.inscriptionTemporaire)
      .subscribe((data: any) => {
        this.router.navigate([this.inscriptionTemporaireSrv.getRoutePrefix(), data.id]);
      }, error => this.inscriptionTemporaireSrv.httpSrv.handleError(error));
  }

}
