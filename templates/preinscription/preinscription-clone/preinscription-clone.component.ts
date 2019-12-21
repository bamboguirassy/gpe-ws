
import { Component, OnInit } from '@angular/core';
import { PreinscriptionService } from '../preinscription.service';
import { Location } from '@angular/common';
import { Preinscription } from '../preinscription';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-preinscription-clone',
  templateUrl: './preinscription-clone.component.html',
  styleUrls: ['./preinscription-clone.component.scss']
})
export class PreinscriptionCloneComponent implements OnInit {
  preinscription: Preinscription;
  original: Preinscription;
  constructor(public preinscriptionSrv: PreinscriptionService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['preinscription'];
    this.preinscription = Object.assign({}, this.original);
    this.preinscription.id = null;
  }

  clonePreinscription() {
    console.log(this.preinscription);
    this.preinscriptionSrv.clone(this.original, this.preinscription)
      .subscribe((data: any) => {
        this.router.navigate([this.preinscriptionSrv.getRoutePrefix(), data.id]);
      }, error => this.preinscriptionSrv.httpSrv.handleError(error));
  }

}
