
import { Component, OnInit } from '@angular/core';
import { EtatReclamationBourseService } from '../etat_reclamation_bourse.service';
import { Location } from '@angular/common';
import { EtatReclamationBourse } from '../etat_reclamation_bourse';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-etat_reclamation_bourse-clone',
  templateUrl: './etat_reclamation_bourse-clone.component.html',
  styleUrls: ['./etat_reclamation_bourse-clone.component.scss']
})
export class EtatReclamationBourseCloneComponent implements OnInit {
  etat_reclamation_bourse: EtatReclamationBourse;
  original: EtatReclamationBourse;
  constructor(public etat_reclamation_bourseSrv: EtatReclamationBourseService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['etat_reclamation_bourse'];
    this.etat_reclamation_bourse = Object.assign({}, this.original);
    this.etat_reclamation_bourse.id = null;
  }

  cloneEtatReclamationBourse() {
    console.log(this.etat_reclamation_bourse);
    this.etat_reclamation_bourseSrv.clone(this.original, this.etat_reclamation_bourse)
      .subscribe((data: any) => {
        this.router.navigate([this.etat_reclamation_bourseSrv.getRoutePrefix(), data.id]);
      }, error => this.etat_reclamation_bourseSrv.httpSrv.handleError(error));
  }

}
