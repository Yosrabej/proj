import { HttpClient } from "@angular/common/http";
import { Component, OnInit } from "@angular/core";
import { FormGroup, FormControl, Validators, FormBuilder, RequiredValidator } from '@angular/forms';
import { Demande } from "../../demande";
import { DemandeService } from "./demande.service";
import { DatePipe } from "@angular/common";

@Component({
  selector: 'app-demande',
  templateUrl: 'demande.component.html',
  styleUrls: ['demande.css']
})
export class DemandeComponent implements OnInit {

  demande: Demande = {
    datedebut: '',
    datefin: '',
    raison: '',
    adresse: '',
    status: '',
  };
  addDemandeForm: any;
  demandeId: any;
  convertedData : any;
  projet: any = [];
  id:any;
  dateDebutFix : any ;
  todayDate=this.datePipe.transform(new Date(), 'yyyy-MM-dd');
  userId: any;
  projId:any;
contrat= localStorage.getItem('talan_userContrat');
projectsByUser:any;
cond:any;
selectedProject:any;
  constructor(private formBuilder: FormBuilder,
    private demandeService: DemandeService, private http: HttpClient , private datePipe: DatePipe
    
  ) { }

  ngOnInit(): void {
    localStorage.getItem('talan_userId')
    this.dateDebutFix = this.todayDate ;
    let userId= localStorage.getItem('talan_userId');
    console.log(this.dateDebutFix );
    this.addDemandeForm = this.formBuilder.group({
      DateDebut: ['', Validators.required ],
      DateFin: ['' , Validators.required  ],
      raison: ['' ,Validators.required ],
      projet: ['' , Validators.required ],
      adresse: ["" , Validators.required ],
    })
    this.id= localStorage.getItem('talan_userId');
   this.projectsByUser=this.http.get(`http://127.0.0.1:8000/api/getProjectsByUser/${this.id}`).subscribe(data=>{this.projet=data,
   this.projet.forEach(elt => {
  if(!elt['surSite'].includes('non'))console.log('inc yes')
  })}
   )
  }

  read(){
    console.log("projet",this.selectedProject)
  }
  addDemande() {
    console.log(this.addDemandeForm.value);
let userId= localStorage.getItem('talan_userId');
    let demande = this.addDemandeForm.value;
    demande['user'] = localStorage.getItem('talan_userId');
    this.demandeService.addDemande(demande).subscribe(
      (res: any) => {
        window.alert('Demande bien envoyer');
        this.demandeId=res;
console.log(this.demandeId);
console.log(this.contrat )


this.projectsByUser=this.http.get(`http://127.0.0.1:8000/api/getProjectsByUser/${this.id}`).subscribe(data=>{
   
   this.projet=data,
 this.projet.forEach(elt => {
   if(!elt['surSite'].includes('oui') && this.contrat == 'true') {this.http.get(`http://127.0.0.1:8000/api/request/${this.demandeId}/${userId}/${this.selectedProject}`).subscribe(data=>console.log(data));
  } else {this.http.get(`http://127.0.0.1:8000/api/refuseA/${this.demandeId}/${userId}`).subscribe(data=>console.log(data))}
 }
)
 })
      },
      (err: any) => {
        console.log(err);
      }
    )

  }

}
