import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { ComponentsRoutes } from './component.routing';

import { NgbdnavBasicComponent } from './nav/nav.component';

import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';

import { UserModule } from './user/user.module';




 


@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(ComponentsRoutes),
    FormsModule,
    ReactiveFormsModule,
    NgbModule,
    NgMultiSelectDropDownModule,
    
    UserModule
    
  ],
  declarations: [

    NgbdnavBasicComponent,


    
  ]
})
export class ComponentsModule { }
