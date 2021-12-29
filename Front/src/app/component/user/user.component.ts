import { Component, OnInit } from '@angular/core';
import { UserService } from './user.service';
import { __core_private_testing_placeholder__ } from '@angular/core/testing';
import { ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {

  public p:any;
  public users : any = [];
  public searchText : string;
  public idTarget: any;
  public nom:any;
  public prenom:any;
  public email:any;
  public contrat:any;
  public role:any;
  actualPage:any;
  nombre_page:any;
  projectPagination:any;
  searchValue :any;
  user:any;
  urlCheck:boolean;
  passwordValue:any;
  newPassword:any;
  alert:boolean = false;
  constructor(private userService: UserService, private route: ActivatedRoute) {
  }

  
  ngOnInit(): void {

    this.route.queryParams
    .subscribe((params:any) => {
    console.log("params from on init", params.page || 1);
    this.actualPage = params.page || 1;


    if(!window.location.href.includes("search"))
    {
      this.urlCheck = true;
      console.log("true")

      this.userService.showUsersWithPaginationById(1).subscribe((data:any)=>{
        this.nombre_page=data[0].nombre_total_page;
        console.log("nous avons un nmbre de page total ", this.nombre_page);
      });
      console.log("page",this.actualPage)
      // if(this.actualPage == 1)
      // {
      // this.userService.showUsersWithPaginationById(1).subscribe((data:any)=>{
      //   console.log("data of first page",data); 
      //   this.projectPagination=data 
      //   this.nombre_page=data[0].nombre_total_page;
      // });
      // }
      // else {
        this.intermediate();
      //  }

    }
    else{
      //when i refresh the page using the search input, i will get the search word from the url, then bind into the input then get the users with that searched word"
      this.route.queryParams.subscribe((params:any) => {
        console.log("params from on search", params );
        this.searchValue=params.search;
         console.log(" this.searchValue", this.searchValue)
        })

        this.userService.getUsersUsingSearch(this.searchValue).subscribe(data=>{
          console.log("data from searching value",data);
          this.urlCheck = false;
          this.projectPagination=data;})
    }

  })

  }

  


  intermediate(){
    if(this.actualPage == 1)
    {
    this.userService.showUsersWithPaginationById(1).subscribe((data:any)=>{
     
      console.log("data of first page",data);
      this.projectPagination=data
      this.nombre_page=data[0].nombre_total_page;
    }, (error)=>console.log("error",error));
    }
    else if (this.actualPage !== 1 ) {
      this.userService.showUsersWithPaginationById(this.actualPage).subscribe(data=>{
        console.log("data of sec or third page",data)
        this.projectPagination=data;})}
    }

  counter() {
    return new Array(this.nombre_page);
  }



getUser(id:any){
  this.userService.getUserById(id).subscribe((data:any)=>{
    console.log("user is: ",data[0]);
    this.idTarget = data[0].id;
    console.log("id is: ",this.idTarget);
    this.nom = data[0].nom;
    this.prenom = data[0].prenom;
    this.email = data[0].username;
    this.contrat = data[0].contrat;
     console.log("nom",this.nom);
    this.role = data[0].role;
    this.passwordValue = data[0].password
  }
    )
}

  deleteUser(){
    this.userService.deleteUserById(this.idTarget).subscribe(data=>{
      console.log("deleted user is",data);
      if(!window.location.href.includes("search"))
      {
        this.userService.getUsers().subscribe((data:any)=>
        {
           console.log("data",data); 
          //  this.users = data;
          //  this.projectPagination=data;
           this.intermediate();
      });
      }
      else if(window.location.href.includes("search"))
      {
        console.log(true)
         this.searchUsers();
      }
    })

  }


  updateUser(){
    this.user= this.userService.updateUserById(this.idTarget,{nom:this.nom,prenom:this.prenom,username:this.email,contrat:this.contrat,role:this.role})
    .subscribe(data=>{
      console.log(data);
      if(!window.location.href.includes("search"))
      {
        this.userService.getUsers().subscribe((data:any)=>
        {
           console.log("data",data); 
           this.intermediate();
      });
      }
     else {
      this.searchUsers();
     }
    });
  }
  
  //get users using the search box
  searchUsers(){
    this.userService.getUsersUsingSearch(this.searchValue).subscribe(data=>{
      console.log("data from searching value",data);
      this.urlCheck = false;
      this.projectPagination=data;

      this.route.queryParams.subscribe((params:any) => {
        console.log("params from on search", params );
        this.searchValue=params.search;
         console.log(" this.searchValue", this.searchValue)
        })
    })
  }

  resetInput(){
    this.searchValue = "";
    this.urlCheck = true;
  }

  resetPassUser(id:any){
    this.userService.resetPassword(id).subscribe(data=>{
      console.log("data from updated password",data);
      this.alert=true;
    })
    window.setTimeout(()=>{
      this.alert=false;
    }, 5000);
  }
}
