
import { Component, OnInit } from '@angular/core';
import { FiliereniveauService } from '../filiereniveau.service';
import { Location } from '@angular/common';
import { Filiereniveau } from '../filiereniveau';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-filiereniveau-clone',
  templateUrl: './filiereniveau-clone.component.html',
  styleUrls: ['./filiereniveau-clone.component.scss']
})
export class FiliereniveauCloneComponent implements OnInit {
  filiereniveau: Filiereniveau;
  original: Filiereniveau;
  constructor(public filiereniveauSrv: FiliereniveauService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['filiereniveau'];
    this.filiereniveau = Object.assign({}, this.original);
    this.filiereniveau.id = null;
  }

  cloneFiliereniveau() {
    console.log(this.filiereniveau);
    this.filiereniveauSrv.clone(this.original, this.filiereniveau)
      .subscribe((data: any) => {
        this.router.navigate([this.filiereniveauSrv.getRoutePrefix(), data.id]);
      }, error => this.filiereniveauSrv.httpSrv.handleError(error));
  }

}
