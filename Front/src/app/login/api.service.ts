import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiService {

  private url = environment.baseURL;
  constructor(private http: HttpClient) {}

  login(username: string, password: string) {
    return this.http.post(this.url+'login_check', { username, password }, { observe: 'response'});
  }
}
