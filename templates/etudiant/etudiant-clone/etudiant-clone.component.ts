
import { Component, OnInit } from '@angular/core';
import { EtudiantService } from '../etudiant.service';
import { Location } from '@angular/common';
import { Etudiant } from '../etudiant';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-etudiant-clone',
  templateUrl: './etudiant-clone.component.html',
  styleUrls: ['./etudiant-clone.component.scss']
})
export class EtudiantCloneComponent implements OnInit {
  etudiant: Etudiant;
  original: Etudiant;
  constructor(public etudiantSrv: EtudiantService, public location: Location,
    public activatedRoute: ActivatedRoute, public router: Router) { }

  ngOnInit() {
    this.original = this.activatedRoute.snapshot.data['etudiant'];
    this.etudiant = Object.assign({}, this.original);
    this.etudiant.id = null;
  }

  cloneEtudiant() {
    console.log(this.etudiant);
    this.etudiantSrv.clone(this.original, this.etudiant)
      .subscribe((data: any) => {
        this.router.navigate([this.etudiantSrv.getRoutePrefix(), data.id]);
      }, error => this.etudiantSrv.httpSrv.handleError(error));
  }

}
