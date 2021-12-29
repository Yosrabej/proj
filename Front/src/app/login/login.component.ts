import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { finalize } from 'rxjs/operators';
import { AuthService } from './auth.service';

import jwt_decode from 'jwt-decode';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { CredentialsService } from './credentials.service';



@Component({
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})



export class LoginComponent implements OnInit {

  // version: string | null = environment.version;
  error: string | undefined;
  loginForm!: FormGroup;
  isLoading = false;
  private readonly TOKEN_NAME = 'talan_auth';
  private readonly USERNAME = 'talan_userName';
  private readonly USERID = 'talan_userId';
  private readonly USERROLE = 'talan_userRole';
  private readonly USEREMAIL = 'talan_userEmail';
  private readonly USERCONTRAT = 'talan_userContrat';
  private username: any;
  private user: any;
  private url = environment.baseURL;




  constructor(private router: Router,
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private http: HttpClient,
    private credentials : CredentialsService) {
    this.createForm();
  }

  ngOnInit() { }

  login() {
    this.authService
      .login(this.loginForm.get('username')?.value, this.loginForm.get('password')?.value)
      .subscribe(
        (response) => {
          localStorage.setItem(this.TOKEN_NAME, response.body.token);
          this.username = jwt_decode(response.body.token);
          this.user = this.username.username;
                    this.router.navigate(['/']);
          window.alert('bienvenue');
          this.getUserData(this.user);
          console.log(this.credentials.isAuthenticated())

          console.log(localStorage.getItem('talan_userRole')); 
          
        },
        (error) => {
          window.alert('Mauvaises entrées!');
        });
  }

  getUserData(user: string) {

    return this.http.post(this.url + 'getUserData', this.user).subscribe(
      data => {
        
        localStorage.setItem(this.USERNAME, data[0].username);
        localStorage.setItem(this.USERID, data[0].id);
        localStorage.setItem(this.USERROLE, data[0].roles);
        localStorage.setItem(this.USEREMAIL, data[0].email);
        localStorage.setItem(this.USERCONTRAT, data[0].typeContrat);
        });

  }

  private createForm() {
    this.loginForm = this.formBuilder.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
      remember: true
    });
  }

 





}
