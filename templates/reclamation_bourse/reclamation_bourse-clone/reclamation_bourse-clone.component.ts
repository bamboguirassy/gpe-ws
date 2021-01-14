
import { Component, OnInit } from '@angular/core';
import { ReclamationBourseService } from '../reclamation_bourse.service';
import { Location } from '@angular/common';
import { ReclamationBourse } from '../reclamation_bourse';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-reclamation_bourse-clone',
  templateUrl: './reclamation_bourse-clone.component.html',
  styleUrls: ['./reclamation_bourse-clone.component.scss']
})
export class ReclamationBourseCloneComponent implements OnInit {
  reclamation_bourse: ReclamationBourse;
  original: ReclamationBourse;
  constructor(public reclamation_bourseSrv: ReclamationBourseService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['reclamation_bourse'];
    this.reclamation_bourse = Object.assign({}, this.original);
    this.reclamation_bourse.id = null;
  }

  cloneReclamationBourse() {
    console.log(this.reclamation_bourse);
    this.reclamation_bourseSrv.clone(this.original, this.reclamation_bourse)
      .subscribe((data: any) => {
        this.router.navigate([this.reclamation_bourseSrv.getRoutePrefix(), data.id]);
      }, error => this.reclamation_bourseSrv.httpSrv.handleError(error));
  }

}
