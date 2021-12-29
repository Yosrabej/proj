import { RouteInfo } from './sidebar.metadata';
import { Roles } from '../../user-roles';
import { ComponentFactoryResolver } from '@angular/core';



export const ROUTES: RouteInfo[] = [
 
  {
    path: '/dashboard',
    title: 'Dashboard',
    icon: 'bi bi-speedometer2',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true
    
  },
  {
    path: '/component/registre',
    title: 'Registre',
    icon: 'bi bi-save',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true

  },
  {
    path: '/component/Demande',
    title: 'Demande télétravail',
    icon: 'bi bi-briefcase',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true

  },
  {
    path: '/component/historique',
    title: 'Historique',
    icon: 'bi bi-archive',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true

  },
  {
    path: '/component/traiter',
    title: 'Traiter demandes',
    icon: 'bi bi-bell',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true

  },
  {
    path: '/component/projet',
    title: 'Créer projet',
    icon: 'bi bi-file-arrow-down',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true

  },
  {
    path: '/component/user',
    title: 'user',
    icon: 'bi bi-bell',
    class: '',
    extralink: false,
    submenu: [],
    expectedRoles: [Roles.ADMIN],
    show: true

  },
  /*{
    path: '/component/badges',
    title: 'Badges',
    icon: 'bi bi-patch-check',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/component/buttons',
    title: 'Button',
    icon: 'bi bi-hdd-stack',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/component/card',
    title: 'Card',
    icon: 'bi bi-card-text',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/component/dropdown',
    title: 'Dropdown',
    icon: 'bi bi-menu-app',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/component/pagination',
    title: 'Pagination',
    icon: 'bi bi-dice-1',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/component/nav',
    title: 'Nav',
    icon: 'bi bi-pause-btn',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/component/table',
    title: 'Table',
    icon: 'bi bi-layout-split',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  },
  {
    path: '/about',
    title: 'About',
    icon: 'bi bi-people',
    class: '',
    extralink: false,
    submenu: [],
    show: true

  }*/
];
