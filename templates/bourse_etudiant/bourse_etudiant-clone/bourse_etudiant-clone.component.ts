
import { Component, OnInit } from '@angular/core';
import { BourseEtudiantService } from '../bourse_etudiant.service';
import { Location } from '@angular/common';
import { BourseEtudiant } from '../bourse_etudiant';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-bourse_etudiant-clone',
  templateUrl: './bourse_etudiant-clone.component.html',
  styleUrls: ['./bourse_etudiant-clone.component.scss']
})
export class BourseEtudiantCloneComponent implements OnInit {
  bourse_etudiant: BourseEtudiant;
  original: BourseEtudiant;
  constructor(public bourse_etudiantSrv: BourseEtudiantService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['bourse_etudiant'];
    this.bourse_etudiant = Object.assign({}, this.original);
    this.bourse_etudiant.id = null;
  }

  cloneBourseEtudiant() {
    console.log(this.bourse_etudiant);
    this.bourse_etudiantSrv.clone(this.original, this.bourse_etudiant)
      .subscribe((data: any) => {
        this.router.navigate([this.bourse_etudiantSrv.getRoutePrefix(), data.id]);
      }, error => this.bourse_etudiantSrv.httpSrv.handleError(error));
  }

}
