import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from "@angular/router";

import { LoginComponent} from "./login.component";

const routes: Routes = [
  {
    path: "login",
    data: {
      title: "log",
      urls: [{ title: "log", url: "/login" }, { title: "login" }],
    },
    component: LoginComponent,
  },
];

@NgModule({
  declarations: [],
  imports: [
    CommonModule
  ]
})
export class LoginModule { }
