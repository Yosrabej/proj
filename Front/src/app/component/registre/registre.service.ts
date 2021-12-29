import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegistreService {
  catgUrl: string = "http://127.0.0.1:8000/api/register";

  constructor(private httpClient: HttpClient) { }

  addRegistre(formBuilder: FormBuilder): Observable<any> {
    return this.httpClient.post<any>(this.catgUrl, formBuilder);
  }
}
