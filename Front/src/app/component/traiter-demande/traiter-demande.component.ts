import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { environment } from '../../../environments/environment';
import { TraiterDemandeService } from './traiter-demande.service';
@Component({
  selector: 'app-traiter-demande',
  templateUrl: './traiter-demande.component.html',
  styleUrls: ['./traiter-demande.component.scss']
})
export class TraiterDemandeComponent implements OnInit {
searchText : any ;
p :any ;
demandes : any = [];
role= localStorage.getItem('talan_userRole');
 id:any;
url = environment.baseURL;
msg:any;
showAlert:boolean=false;
showAlertRefused:boolean=false;
loader:boolean=false;
  constructor(private http: HttpClient, private filtredService: TraiterDemandeService) { }

  ngOnInit(): void {
    console.log(this.role);
    if (this.role=="ROLE_MANAGERPROX"){
    this.filtredService.filtredDemandesProx().subscribe(data=>{
      console.log(data[0])
      this.demandes = data ;})} else if(this.role=="ROLE_MANAGER"){
        this.filtredService.filtredDemandes().subscribe(data=>{
          console.log(data[0].user)
          this.demandes = data ;})
      }
    
  }
refuse(id:any){
 
if ( this.role=="ROLE_MANAGER"){
  this.showAlertRefused=true;
  window.setTimeout(()=>{
    this.showAlertRefused=false;
    }, 2000)
 //  confirm('Confirmez-vous le refus de la demande?')
 this.filtredService.refuseE(id).subscribe(data=>console.log(data))
 this.filtredService.refuser(id).subscribe(data=>console.log(data))
}
else if ( this.role=="ROLE_MANAGERPROX" ){
  this.showAlertRefused=true;
  window.setTimeout(()=>{
    this.showAlertRefused=false;
    }, 2000)
 // confirm('Confirmez-vous le refus de la demande?')
this.filtredService.refuseP(id).subscribe(data=>console.log(data))
this.filtredService.refuser(id).subscribe(data=>console.log(data))
}
}
/*validate(id: any){
  if (this.role=="ROLE_MANAGERPROX" && confirm('Confirmez-vous la validation de la demande?')== true){
    this.filtredService.managerPvalidate(id).subscribe(data=>console.log(data))
   // if(confirm('Envoyer un mail de validation?')== true) {
   this.filtredService.validate(id).subscribe(data=>console.log(data))}
 //  } 
   //else {
    // return;
    //this.filtredService.cancel(id).subscribe(data=>console.log(data))
//}
 // } 
  else if (this.role=="ROLE_MANAGER" && confirm('Confirmez-vous la validation de la demande?')== true){
    this.filtredService.managerEvalidate(id).subscribe(data=>console.log(data))
   // if(confirm('Envoyer un mail de validation?')== true) {
      this.filtredService.validate(id).subscribe(data=>console.log(data))}
 //  }else {
   // this.filtredService.cancel(id).subscribe(data=>console.log(data))
  //  }
    else{
      this.filtredService.cancel(id).subscribe(data=>console.log(data))
    }
  } */
//}

chargerData(){
  this.filtredService.filtredDemandes().subscribe(data=>{
    console.log(data[0].user)
    if(!data) this.loader=true
    else
    this.demandes = data
    this.loader=false ;})
}
validate(id:any){
  if ((this.role=="ROLE_MANAGERPROX" )) {
   // console.log(this.showAlert)
    this.showAlert==true;
 this.filtredService.managerPvalidate(id).subscribe(data=>console.log(data))
 this.filtredService.valider(id).subscribe(data=>console.log(data))
 console.log(this.showAlert)
 //this.http.get(this.url+`validateP/${id}`).subscribe(data=>console.log(data))
}else if ( this.role=="ROLE_MANAGER" ){
  //console.log(this.showAlert)
  this.showAlert=true;
  window.setTimeout(()=>{
    this.showAlert=false;
    }, 2000)
    this.filtredService.managerEvalidate(id).subscribe(data=>console.log(data))
    this.filtredService.valider(id).subscribe(data=>console.log(data))

this.chargerData();




console.log(this.showAlert)
//this.http.get(this.url+`validateE/${id}`).subscribe(data=>console.log(data))
}
}
confirm(id:any){
  if ((this.role=="ROLE_MANAGERPROX" ) ){
  //  this.filtredService.managerPvalidate(id).subscribe(data=>console.log(data))
    this.filtredService.valider(id).subscribe(data=>console.log(data))
   //this.http.get(this.url+`validateP/${id}`).subscribe(data=>console.log(data))
   }else if ( this.role=="ROLE_MANAGER"){
  // this.filtredService.managerEvalidate(id).subscribe(data=>console.log(data))
   this.filtredService.valider(id).subscribe(data=>console.log(data))
  // this.http.get(this.url+`validateE/${id}`).subscribe(data=>console.log(data))
   }}
   cancelValidation(id:any){
    if ((this.role=="ROLE_MANAGERPROX" ) ){
    this.filtredService.cancelP(id).subscribe(data=>console.log('cancel'))
    this.filtredService.cancelP2(id).subscribe(data=>console.log('cancelP'))
    this.filtredService.cancelRefusedP(id).subscribe(data=>console.log('cancelled'))
    this.filtredService.cancelRefused(id).subscribe(data=>console.log('cancelled'))
    }else if ( this.role=="ROLE_MANAGER"){
    this.filtredService.cancelE(id).subscribe(data=>console.log('cancel'))
    this.filtredService.cancelE2(id).subscribe(data=>console.log('cancelE'))
    this.filtredService.cancelRefusedE(id).subscribe(data=>console.log('cancelled'))
   // this.filtredService.cancelRefused(id).subscribe(data=>console.log('cancelled'))
    this.filtredService.cancelvalidatedManagerOnly(id).subscribe(data=>console.log('cancelled'))
    this.filtredService.cancelrefusedManagerOnly(id).subscribe(data=>console.log('cancelled'))
  }

   }
   canceltest(id:any){
    this.filtredService.canceltest(id).subscribe(data=>console.log('cancelledTest'))
   }
}
