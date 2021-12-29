import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import  {User} from '../../user'
import { Observable } from 'rxjs';
import {Project} from '../../projet'
import { environment } from '../../../environments/environment';
@Injectable({
  providedIn: 'root'
})



export class UserService{

  private url = environment.baseURL;
   
  constructor(private http: HttpClient) { }


  getUsers(): Observable<User>{
    return this.http.get<User>(this.url+"users");
  }

  getUsersRoleUsers() : Observable<User>{
    return this.http.get<User>(this.url+'ROLE_USER/users');
  }

  getUsersRoleAdmin() : Observable<User>{
    return this.http.get<User>(this.url+"ROLE_ADMIN/users");
  }

  getUsersRoleManager() : Observable<User>{
    return this.http.get<User>(this.url+"ROLE_MANAGER/users");
  }

  getUsersRoleManagerProx() : Observable<User>{
    return this.http.get<User>(this.url+"ROLE_MANAGERPROX/users");
  }

  getProjectInformation(body:any) : Observable<Project>{
    return this.http.post<Project>(this.url+"create",body);
  }

  deleteUserById(id:any) :  Observable<User>{
    return this.http.get<User>(this.url+`deleteUser/${id}`);
  }

  getUserById(id:any): Observable<User>{
    return this.http.get<User>(this.url+`user/${id}`);
  }

  updateUserById(id:any,body:any) : Observable<User>{
    return this.http.put<User>(this.url+`update/user/${id}`,body);
  }

  showUsersWithPagination() : Observable<User>{
    return this.http.get<User>(this.url+"Userpagination");
  }
  
  showUsersWithPaginationById(page:any) : Observable<User>{
    return this.http.get<User>(this.url+`Userpagination/${page}`);
  }

  getUsersUsingSearch(word:any) : Observable<User>{
    return this.http.get<User>(this.url+`search/${word}`);
  }

  resetPassword(id:any): Observable<User>{
    return this.http.get<User>(this.url+`resetPassword/${id}`);
  }
}
