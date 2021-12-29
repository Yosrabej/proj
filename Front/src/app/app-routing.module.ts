import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { FullComponent } from './layouts/full/full.component';
import { LoginComponent } from './login/login.component';
import { AuthenticationGuard as AuthGuard   } from './login/authentication.guard';
import { RoleGuardService as RoleGuard   } from './login/role-guard.service';
import { Roles } from './user-roles';

export const Approutes: Routes = [
  {
    path: '',
    component: FullComponent,
   
    children: [
      { path: '',  redirectTo: '/dashboard', pathMatch: 'full' },
      {
        path: 'dashboard',
        
        loadChildren: () => import('./dashboard/dashboard.module').then(m => m.DashboardModule),
        
      },
      {
        path: 'about',
        loadChildren: () => import('./about/about.module').then(m => m.AboutModule),
       
      },
      {
        path: 'component',
        
        loadChildren: () => import('./component/component.module').then(m => m.ComponentsModule),
        
      }
      
    ],
    
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: '**',
    redirectTo: '/starter'
  }
];
