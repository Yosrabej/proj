import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';

//import { Logger } from '@shared';
import { CredentialsService } from './credentials.service';

//const log = new Logger('AuthenticationGuard');

@Injectable({
  providedIn: 'root',
})
export class AuthenticationGuard implements CanActivate {
  constructor(private router: Router, private credentialsService: CredentialsService) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    if (this.credentialsService.isAuthenticated()) {
        console.log(this.credentialsService.isAuthenticated());
      return true;
      
    }

    console.log('Not authenticated, redirecting and adding redirect url...');
    window.alert('Vous devez être authentifié pour visualiser cette page!');
    this.router.navigate(['/login'], { queryParams: { redirect: state.url }, replaceUrl: true });
    return false;
  }
}
