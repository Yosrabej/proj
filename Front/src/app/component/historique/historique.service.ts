import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Demande } from "../../demande";
import { Observable } from 'rxjs';
import { environment } from "../../../environments/environment";


@Injectable({
  providedIn: 'root'
})
export class HistoriqueService {
  private url = environment.baseURL +'affichedemande/' ;
  public historique : any = [];
  constructor(private http: HttpClient) { }

  ListHistorique(): Observable<any> {
    localStorage.getItem('talan_userId');
  return this.http.get<Demande[]>(this.url+ localStorage.getItem('talan_userId'));
  }
}
