import { Ng2SearchPipeModule } from 'ng2-search-filter';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TranslateModule } from '@ngx-translate/core';
import { UserComponent } from "./user.component";
import {NgxPaginationModule} from 'ngx-pagination';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';
import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';
import { Routes, RouterModule } from '@angular/router'; 
const routes: Routes = [];
@NgModule({
  imports: [RouterModule.forChild(routes),CommonModule,CommonModule, TranslateModule,NgxPaginationModule,FormsModule,ReactiveFormsModule,Ng2SearchPipeModule,NgMultiSelectDropDownModule.forRoot()],
  declarations: [UserComponent],
})
export class UserModule {}