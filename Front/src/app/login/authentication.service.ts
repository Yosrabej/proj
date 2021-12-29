import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Credentials, CredentialsService } from './credentials.service';
import { Router, ActivatedRoute } from '@angular/router';
import { environment } from '../../environments/environment';

export interface LoginContext {
  username: string;
  password: string;
  remember?: boolean;
}

/**
 * Provides a base for authentication workflow.
 * The login/logout methods should be replaced with proper implementation.
 */
@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {
  constructor(private credentialsService: CredentialsService, private http: HttpClient, private router: Router,
    private route: ActivatedRoute) {}
private url = environment.baseURL;
  

  /**
   * Logs out the user and clear credentials.
   * @return True if the user was logged out successfully.
   */
  logout(): Observable<boolean> {
    // Customize credentials invalidation here
    this.credentialsService.setCredentials();
    localStorage.removeItem('talan_auth');
    localStorage.removeItem('talan_userName');
    localStorage.removeItem('talan_userId');
    localStorage.removeItem('talan_userRole');
    localStorage.removeItem('talan_userEmail');
    this.router.navigate(['/login']);
    return of(true);
  }
}
