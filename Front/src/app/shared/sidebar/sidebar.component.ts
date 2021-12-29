import { Component, AfterViewInit, OnInit } from '@angular/core';
import { ROUTES } from './menu-items';
import { RouteInfo } from './sidebar.metadata';
import { Router, ActivatedRoute, Routes } from '@angular/router';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
//declare var $: any;

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html'
})
export class SidebarComponent implements OnInit {
  showMenu = '';
  showSubMenu = '';
  public sidebarnavItems:RouteInfo[]=[];
  public userRole = localStorage.getItem('talan_userRole') as string;
  public showElement:boolean  ;



  // this is for the open close
  addExpandClass(element: string) {
    if (element === this.showMenu) {
      this.showMenu = '0';
    } else {
      this.showMenu = element;
    }
  }

  hasAccess(){
    
    if(ROUTES['expectedRoles'] = this.userRole)
    this.showElement = true;
    else
    this.showElement = false;
     
  }

  constructor(
    private modalService: NgbModal,
    private router: Router,
    private route: ActivatedRoute,
    
     
  ) {
    
  }

  // End open close
  ngOnInit() {
    this.sidebarnavItems = ROUTES.filter(sidebarnavItem => sidebarnavItem);
    this.hasAccess();
  }

}
