
import { Component, OnInit } from '@angular/core';
import { TypedocumentService } from '../typedocument.service';
import { Location } from '@angular/common';
import { Typedocument } from '../typedocument';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-typedocument-clone',
  templateUrl: './typedocument-clone.component.html',
  styleUrls: ['./typedocument-clone.component.scss']
})
export class TypedocumentCloneComponent implements OnInit {
  typedocument: Typedocument;
  original: Typedocument;
  constructor(public typedocumentSrv: TypedocumentService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['typedocument'];
    this.typedocument = Object.assign({}, this.original);
    this.typedocument.id = null;
  }

  cloneTypedocument() {
    console.log(this.typedocument);
    this.typedocumentSrv.clone(this.original, this.typedocument)
      .subscribe((data: any) => {
        this.router.navigate([this.typedocumentSrv.getRoutePrefix(), data.id]);
      }, error => this.typedocumentSrv.httpSrv.handleError(error));
  }

}
