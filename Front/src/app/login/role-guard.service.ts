import { Injectable } from '@angular/core';
import { Router,  CanActivate,  ActivatedRouteSnapshot} from '@angular/router';
import { CredentialsService } from './credentials.service';
import decode from 'jwt-decode';
@Injectable()
export class RoleGuardService implements CanActivate {
  constructor(public auth: CredentialsService, public router: Router) {}


  canActivate(route: ActivatedRouteSnapshot): boolean {
    // this will be passed from the route config
    // on the data property
    const expectedRole = route.data.expectedRole;
    const role =  localStorage.getItem('talan_userRole'); 
    
  
    
  
    if (
      !this.auth.isAuthenticated() || 
      role !== expectedRole
    ) {
        console.warn(role);
        window.alert("Vous devez être authentifié!");
      this.router.navigate(['/login']);
      return false;
    }
    return true;
  }
}