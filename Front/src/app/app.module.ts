import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {
  CommonModule, LocationStrategy,
  PathLocationStrategy
} from '@angular/common';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS,HttpClient } from '@angular/common/http';
import { Routes, RouterModule } from '@angular/router';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

import { FullComponent } from './layouts/full/full.component';


import { NavigationComponent } from './shared/header/navigation.component';
import { SidebarComponent } from './shared/sidebar/sidebar.component';
import { Approutes } from './app-routing.module';
import { AppComponent } from './app.component';
import { SpinnerComponent } from './shared/spinner.component';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';
import { PERFECT_SCROLLBAR_CONFIG } from 'ngx-perfect-scrollbar';
import { PerfectScrollbarConfigInterface } from 'ngx-perfect-scrollbar';
import { LoginComponent } from './login/login.component';
import { AuthInterceptor } from '../app/login/auth.interceptor';
import { DemandeComponent } from './component/Demande/demande.component';
import { HistoriqueComponent } from './component/historique/historique.component';
import {Ng2SearchPipeModule} from 'ng2-search-filter';
import {NgxPaginationModule} from 'ngx-pagination';
import { DatePipe } from '@angular/common'
import { RegistreComponent } from './component/registre/registre.component';
import { ProfileComponent } from './component/profile/profile.component';
import { RoleGuardService as RoleGuard   } from './login/role-guard.service';
import { RouteInfo } from './shared/sidebar/sidebar.metadata';
import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';
import { TraiterDemandeComponent } from './component/traiter-demande/traiter-demande.component';
import { ProjectComponent } from './component/project/project.component';





const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
  suppressScrollX: true,
  wheelSpeed: 1,
  wheelPropagation: true,
  minScrollbarLength: 20
};

@NgModule({
  declarations: [
    AppComponent,
    SpinnerComponent,
    FullComponent,
    DemandeComponent,
    RegistreComponent,
    ProfileComponent,
    HistoriqueComponent,
    NavigationComponent,
    SidebarComponent,
    LoginComponent,
    TraiterDemandeComponent, ProjectComponent
  ],
  imports: [
    CommonModule,
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    Ng2SearchPipeModule,
    NgxPaginationModule,
    NgbModule,
    RouterModule.forRoot(Approutes, { useHash: false, relativeLinkResolution: 'legacy' }),
    PerfectScrollbarModule,
    NgMultiSelectDropDownModule
    
  ],
  providers: [


  
    [RoleGuard],
    {
      
      provide: LocationStrategy,
      useClass: PathLocationStrategy
    },
  [DatePipe],
    {

      provide : HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi   : true,

    },

    {
      provide: PERFECT_SCROLLBAR_CONFIG,
      useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
