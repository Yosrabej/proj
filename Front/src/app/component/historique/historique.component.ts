import { DatePipe } from "@angular/common";
import { HttpClient } from "@angular/common/http";
import { Component, OnInit } from "@angular/core";
import { Observable } from "rxjs";
import { Demande } from "../../demande";
import { HistoriqueService } from "./historique.service";
import { environment } from "../../../environments/environment";







@Component({
  templateUrl: "historique.component.html",
})


export class HistoriqueComponent implements OnInit { 
  name= localStorage.getItem('talan_userName');
  searchText : any ;
  p :any ;
  SelectedDate : any ;
  private url = environment.baseURL +'affichedemande/' ;
  
 
  
  public historique : any = [];

  public dates:any[] = [];
  public date:any;
  public latest_date:any;
  public latest_date_fin:any;
  public myId : any ;
  public myStatus : any ;
  status1 : any ;

  constructor(private http: HttpClient , public datepipe: DatePipe , private historiqueService:HistoriqueService ) {
    
   }

    


  ngOnInit(): void {
  
   // 

  //localStorage.getItem('talan_userId');
  //this.historique= this.http.get(this.url+ localStorage.getItem('talan_userId'));
  this.historiqueService.ListHistorique().subscribe(data =>{
    //console.log(data[0].dateDebut);
    console.log(data[0].status)
    //console.log(data[0].dateFin);
    this.latest_date = data[0].dateDebut;
    this.latest_date_fin = data[0].dateFin;
    this.status1 = data[0].status;
    //  this.latest_date =this.datepipe.transform(this.date, 'yyyy-MM-dd');
    // this.latest_date = data[0].dateDebut.date.toLocaleDateString();
    this.historique = data;  
      console.log(data);
      
    })
 
  }

  showId(id : any , status:any){
    this.historiqueService.ListHistorique().subscribe(data =>{
    this.myId = id ;
    //console.log(this.myId);
    this.myStatus = status ;
    //console.log(this.myStatus);
   if(this.myStatus == '[object Object]'){
    status = 'Pas encore validé' ;
   return this.myStatus = status ;
   }else{
    status = 'Validé par votre manager' ;
    return this.myStatus = status ;
   }
    }) ;
  }
  
}
