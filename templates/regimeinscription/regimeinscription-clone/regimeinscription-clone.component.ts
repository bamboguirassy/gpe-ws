
import { Component, OnInit } from '@angular/core';
import { RegimeinscriptionService } from '../regimeinscription.service';
import { Location } from '@angular/common';
import { Regimeinscription } from '../regimeinscription';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-regimeinscription-clone',
  templateUrl: './regimeinscription-clone.component.html',
  styleUrls: ['./regimeinscription-clone.component.scss']
})
export class RegimeinscriptionCloneComponent implements OnInit {
  regimeinscription: Regimeinscription;
  original: Regimeinscription;
  constructor(public regimeinscriptionSrv: RegimeinscriptionService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['regimeinscription'];
    this.regimeinscription = Object.assign({}, this.original);
    this.regimeinscription.id = null;
  }

  cloneRegimeinscription() {
    console.log(this.regimeinscription);
    this.regimeinscriptionSrv.clone(this.original, this.regimeinscription)
      .subscribe((data: any) => {
        this.router.navigate([this.regimeinscriptionSrv.getRoutePrefix(), data.id]);
      }, error => this.regimeinscriptionSrv.httpSrv.handleError(error));
  }

}
