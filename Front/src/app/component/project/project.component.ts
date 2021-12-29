import { Component, OnInit } from '@angular/core';
import { ProjectService } from './project.service';
import { IDropdownSettings } from 'ng-multiselect-dropdown';
import { FormBuilder, Validators, FormControl, FormGroup } from '@angular/forms';
import { ActivatedRoute} from "@angular/router";
import {Router} from "@angular/router";


@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['./project.component.scss']
})
export class ProjectComponent implements OnInit {

  p:any;
  users : any = [];
  roleUsers :any= [];
  roleAdmin : any = [];
  roleManager : any = [];
  roleManagerProx : any = [];
  searchText : string;
  dropdownSettings:IDropdownSettings;
  dropdownSettings1:IDropdownSettings;
  selectedCollab:any = [];
  selectedManager:any;
  selectedManagerProx:any;
  selectedOption : any;
  nomProjet: any;
  projects : any= [];
  idProject : any;
  CreationForm: any;
  updateForm:any;
  projectPagination:any=[];
  actualPage:any;
  nombre_page :any;
  searchValue:any;
  urlCheck:boolean;
  form: FormGroup;
  usernameManager:any;
  usernameManagerProx:any;
  constructor(private projectService: ProjectService, private fb: FormBuilder,private route: ActivatedRoute) {
  }


 
  
  ngOnInit(): void {

      this.route.queryParams
      .subscribe((params:any) => {
      console.log("params from on init", params.page || 1);
      this.actualPage = params.page || 1;
      console.log("page from on init",this.actualPage);

      if (!window.location.href.includes("search"))
      {
        //condition pour savoir si on va afficher la pagination suite à la recherche ou tous les projets
        this.urlCheck = true;
        console.log("true")
        
        //pour avoir les projets de la première page
        this.projectService.showProjectsWithPaginationById(1).subscribe((data:any)=>{
          this.nombre_page=data[0].nombre_total_page;
          console.log("nous avons un nmbre de page total ", this.nombre_page);
        });
       

      //si on est dans la première page
      if(this.actualPage == 1)
      {
      this.projectService.showProjectsWithPaginationById(1).subscribe((data:any)=>{
        console.log("data of first page",data);
        if(data.length>=1)
        {
          this.projectPagination=data
        }
        
        this.nombre_page=data[0].nombre_total_page;
      });
      }
      //appeler la fonction pour afficher les projets par page
      else {
        this.intermediate();
      }
    }
   //si nous avons le terme search dans l'URL
    else {
      //on va récupérer la valeur du search
      this.route.queryParams.subscribe((params:any) => {
        console.log("params from on search", params );
        this.searchValue=params.search;
         console.log(" this.searchValue", this.searchValue)
        })
        
        //on va récupérer les projets filtrés avec ce terme
        this.projectService.geProjectsUsingSearch(this.searchValue).subscribe(data=>{
          console.log("data from searching value",data);
          this.urlCheck = false;
          this.projectPagination=data;})
    }



      })
        
   
  
    this.projectService.getProjects().subscribe((data : any)=>{
      console.log("project data",data);
      
        this.projects = data;
     
        
        this.dropdownSettings = {
          singleSelection: true,
          closeDropDownOnSelection: true,
          idField: 'id',
          textField: 'username',
          selectAllText: 'Select All',
          unSelectAllText: 'UnSelect All',
          allowSearchFilter: true
        };
  
        this.dropdownSettings1 = {
          singleSelection: false,
          closeDropDownOnSelection: true,
           idField: 'id',
          textField: 'username',
          selectAllText: 'Select All',
          unSelectAllText: 'UnSelect All',
          itemsShowLimit: 3,
          allowSearchFilter: true
        };
      
    })

    this.CreationForm = this.fb.group(
      {
        nom: new FormControl('', [Validators.required, Validators.minLength(4)]),
        collaborateurs: new FormControl(null, Validators.required),
        manager: new FormControl(null, Validators.required),
        managerprox: [''],
        surSite: new FormControl(null, Validators.required)
      });
    
  }

  intermediate(){
    if(this.actualPage == 1)
    {
    this.projectService.showProjectsWithPaginationById(1).subscribe((data:any)=>{
      console.log("data of first page",data);
      this.projectPagination=data
      this.nombre_page=data[0].nombre_total_page;
    });
    }
    else if (this.actualPage !== 1 ) {
      this.projectService.showProjectsWithPaginationById(this.actualPage).subscribe(data=>{
        console.log("data of sec or third page",data)
        this.projectPagination=data;})}
    }

  counter() {
    return new Array(this.nombre_page);
  }
  onItemSelect(item: any) {
    console.log("item",item);
  }
  onSelectAll(items: any) {
    console.log(items);
  }
  
  selectedPage(){
    console.log("we are in the page : ",this.actualPage)
  }


  showFirstPages()
  {
  this.projectService.showProjectsWithPaginationById(1).subscribe((data:any)=>{
    console.log("data of first page",data);
    this.projectPagination=data
    this.nombre_page=data[0].nombre_total_page;
  });
  }
 
  clickedOptionCollab(){
    console.log("selected collab :",this.selectedCollab)
    console.log("selected collab type :",typeof(this.selectedCollab))
  }


  clickedOption(){
    console.log("selected option is :",this.selectedOption)
  }

  clickedOptionManager(){
    console.log("selectd manager : ",this.selectedManager)
    this.usernameManager=this.selectedManager[0].username;
    console.log(" this.usernameManager : ", this.usernameManager)
  }

  clickedOptionManagerProx(){
    console.log("selected manager prox : ",this.selectedManagerProx)
    this.usernameManagerProx=this.selectedManagerProx[0].username
    console.log("this.usernameManagerProx ",this.usernameManagerProx)
  }



  //get all users
  getUsers(){
     this.projectService.getUsersRoleUsers().subscribe((data:any)=>{
      console.log("data",data);
      this.roleUsers=data;
    })
    
    this.roleAdmin = this.projectService.getUsersRoleAdmin().subscribe((data:any)=>{
      console.log("data",data);
      this.roleAdmin=data;
    })
   this.projectService.getUsersRoleManager().subscribe((data:any)=>{
      console.log("data role manager",data);
      this.roleManager=data;
    })
      this.projectService.getUsersRoleManagerProx().subscribe((data:any)=>{
      console.log("data",data);
      this.roleManagerProx=data;
    })
  }


  //create a project
  getProjectData(){
     this.projectService.getProjectInformation({nom:this.nomProjet,collab:this.selectedCollab,manager:this.selectedManager,managerprox:this.selectedManagerProx,surSite:this.selectedOption})
    .subscribe((data:any)=>
      {
      console.log("data",data);
        this.projectPagination.push(data);
        this.CreationForm.reset();
        this.intermediate();
    }
      )
  }


    //find a project by id
  findProjectById(id:any){
  this.projectService.getProjectById(id).subscribe((data: any)=>
  {
    this.idProject=data[0].id;
    this.nomProjet =data[0].nom;

  console.log("full data",data[0]);
this.selectedCollab = data[0].collaborateur;
console.log("selected collab from here", this.selectedCollab)

this.selectedManager = data[0].manager;
console.log("selected manager from here", this.selectedManager)
this.usernameManager=this.selectedManager[0].username;
console.log("this.usernameManager",this.usernameManager)


this.selectedManagerProx = data[0].managerProx;
this.usernameManagerProx=this.selectedManagerProx[0].username;
console.log("this.usernameManagerProx",this.usernameManagerProx)

console.log("selected manager prox from here", this.selectedManagerProx)

this.selectedOption = data[0].surSite;
console.log("selected option sur site  from here", this.selectedOption)

})
  }

  //updated a project
    updateProject(){
    console.log("id project", this.idProject)
    this.projectService.updateProjectById(this.idProject,{nom:this.nomProjet,collab:this.selectedCollab,manager:this.selectedManager,managerprox:this.selectedManagerProx || null,surSite:this.selectedOption}).subscribe((data:any)=>
   { console.log("returned updated",data);

   if(!window.location.href.includes("search"))
   {
     this.projectService.getProjects().subscribe((data:any)=>
     {
        console.log("data",data); 
        this.intermediate();
   });
   }
  else {
   this.searchProjects();
  }

  })
  }
   
  //delete a project
  deleteProject(){
    this.projectService.deleteProjectById(this.idProject).subscribe(data=>{
      console.log("returned data from deleted function",data)

      if(!window.location.href.includes("search"))
      {
        this.projectService.getProjects().subscribe((data:any)=>
        {
           console.log("data",data); 
 
           this.intermediate();
      });
      }
      else if(window.location.href.includes("search"))
      {
        this.searchProjects();
      }
  })}


   //get users using the search box
   searchProjects(){
    this.projectService.geProjectsUsingSearch(this.searchValue).subscribe(data=>{
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


  resetForm(){
    this.CreationForm.reset();
    console.log("this.CreationForm",this.CreationForm.value)
  }

}
