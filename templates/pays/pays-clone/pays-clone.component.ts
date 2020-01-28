
import { Component, OnInit } from '@angular/core';
import { PaysService } from '../pays.service';
import { Location } from '@angular/common';
import { Pays } from '../pays';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-pays-clone',
  templateUrl: './pays-clone.component.html',
  styleUrls: ['./pays-clone.component.scss']
})
export class PaysCloneComponent implements OnInit {
  pay: Pays;
  original: Pays;
  constructor(public paySrv: PaysService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['pay'];
    this.pay = Object.assign({}, this.original);
    this.pay.id = null;
  }

  clonePays() {
    console.log(this.pay);
    this.paySrv.clone(this.original, this.pay)
      .subscribe((data: any) => {
        this.router.navigate([this.paySrv.getRoutePrefix(), data.id]);
      }, error => this.paySrv.httpSrv.handleError(error));
  }

}
