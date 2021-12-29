import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import  {User} from '../../user'
import { Observable } from 'rxjs';
import {Project} from '../../projet'
import { environment } from '../../../environments/environment';
@Injectable({
  providedIn: 'root'
})

export class ProjectService {

  url =  environment.baseURL;
  constructor(private http: HttpClient) { }


  // getUsers(): Observable<User>{
  //   return this.http.get<User>("http://127.0.0.1:8000/users");
  // }

  getProjects(): Observable<Project>{
    return this.http.get<Project>(this.url+"projects");
  }

  getUsersRoleUsers() : Observable<User>{
    return this.http.get<User>(this.url+"ROLE_USER/users");
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

  getProjectById(id:any) : Observable<Project>{
    return this.http.get<Project>(this.url+`project/${id}`);
  }

  updateProjectById(id:any, body:any) : Observable<Project>{
    return this.http.put<Project>(this.url+`update/${id}`,body);
  }
   
  deleteProjectById(id:any) :  Observable<Project>{
    return this.http.delete<Project>(this.url+`delete/${id}`);
}

showProjectsWithPagination() : Observable<Project>{
  return this.http.get<Project>(this.url+"pagination");
}

showProjectsWithPaginationById(page:any) : Observable<Project>{
  return this.http.get<Project>(this.url+`pagination/${page}`);
}

geProjectsUsingSearch(word:any) : Observable<Project>{
  return this.http.get<Project>(this.url+`searchProject/${word}`);
}

}