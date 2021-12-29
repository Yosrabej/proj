import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { ApiService } from './api.service';
import jwt_decode from 'jwt-decode';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private _isLoggedIn$ = new BehaviorSubject<boolean>(false);
  private readonly TOKEN_NAME = 'talan_auth';
  isLoggedIn$ = this._isLoggedIn$.asObservable();
  public username:any;
  public user:any;
  private url = environment.baseURL;
 
   

  get token(): any {
    return localStorage.getItem(this.TOKEN_NAME);
  }

  constructor(private apiService: ApiService, private http: HttpClient) {
   // this._isLoggedIn$.next(!!this.token);
  }

  login(username: string, password: string) {
    return this.http.post(this.url+'login_check', { username, password }, { observe: 'response'}).pipe(
      tap((response: any) => {
        localStorage.setItem(this.TOKEN_NAME, response.body.token);  
        this.username = jwt_decode(response.body.token);
        this.user = this.username.username;
        console.log(this._isLoggedIn$);
           
      })
    );
  }


  
  

 
}
