import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Demande } from '../../demande';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
@Injectable({
  providedIn: 'root'
})
export class TraiterDemandeService {
id:any;
projId:any;
url = environment.baseURL;
  constructor(private http: HttpClient) { }
  filtredDemandes(): Observable<any>{
    this.id= localStorage.getItem('talan_userId');
    return this.http.get<Demande[]>(`http://127.0.0.1:8000/api/filtredDemandes/${this.id}`);
  }
  filtredDemandesProx(): Observable<any>{
    this.id= localStorage.getItem('talan_userId');
    return this.http.get<Demande[]>(`http://127.0.0.1:8000/api/filtredDemandesProx/${this.id}`);

  }
  refuser(id:any): Observable<any>{
    return  this.http.get(this.url+`refuse/${id}`)
  }
  refuseE(id:any):Observable<any>{
  return this.http.get(this.url+`refuseE/${id}`)
  }
  refuseP(id:any):Observable<any>{
    return this.http.get(this.url+`refuseP/${id}`)
    }
  managerPvalidate(id:any): Observable<any>{
   return  this.http.get(this.url+`managerPvalidate/${id}`)
  }
  managerEvalidate(id:any): Observable<any>{
    return this.http.get(this.url+`managerEvalidate/${id}`)
  }
  valider(id:any): Observable<any>{
    return this.http.get(this.url+`validate/${id}`)
  }
  cancelP(id:any): Observable<any>{
    return this.http.get(this.url+`cancelvalidationP/${id}`)
  }
  cancelP2(id:any): Observable<any>{
    return this.http.get(this.url+`cancelvalidationP2/${id}`)
  }

  cancelE(id:any): Observable<any>{
    return this.http.get(this.url+`cancelvalidationE/${id}`)
  }
  cancelE2(id:any): Observable<any>{
    return this.http.get(this.url+`cancelvalidationE2/${id}`)
  }
  cancelRefused(id:any): Observable<any>{
    return this.http.get(this.url+`cancelrefused/${id}`)
  }
  cancelRefusedP(id:any): Observable<any>{
    return this.http.get(this.url+`cancelrefusedP/${id}`)
  }
  cancelRefusedE(id:any): Observable<any>{
    return this.http.get(this.url+`cancelrefusedE/${id}`)
  }
  cancelvalidatedManagerOnly(id:any): Observable<any>{
    return this.http.get(this.url+`cancelvalidatedManagerOnly/${id}`)
  }
  cancelrefusedManagerOnly(id:any): Observable<any>{
    return this.http.get(this.url+`cancelrefusedManagerOnly/${id}`)
  }
  canceltest(id:any): Observable<any>{
    return this.http.get(this.url+`canceltest/${id}`)
  }
}
