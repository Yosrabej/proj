import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit {
 name= localStorage.getItem('talan_userName');
 email= localStorage.getItem('talan_userEmail');
 role= localStorage.getItem('talan_userRole');
 roles:any ;
  constructor() { }

  ngOnInit(): void {

    if(this.role == 'ROLE_USER'){

      this.roles = 'Collaborateur';
  
      }
  
      if(this.role == 'ROLE_ADMIN'){
  
        this.roles = 'Administrateur';
  
        }
  
      if(this.role == 'ROLE_MANAGERPROX' ||  this.role == 'ROLE_MANAGER'){
  
          this.roles = 'Manager';
  
          }
  
    }
  }


