import { Routes } from '@angular/router';

import { NgbdnavBasicComponent } from './nav/nav.component';

import { DemandeComponent } from './Demande/demande.component';
import { HistoriqueComponent } from './historique/historique.component';
import { RegistreComponent } from './registre/registre.component';
import { ProfileComponent } from './profile/profile.component';
import { AuthenticationGuard as AuthGuard   } from '../login/authentication.guard';
import { RoleGuardService as RoleGuard   } from '../login/role-guard.service';
import { ProjectComponent } from './project/project.component';
import { TraiterDemandeComponent } from './traiter-demande/traiter-demande.component';
import { UserComponent } from './user/user.component';

 


export const ComponentsRoutes: Routes = [
	{
		path: '',
		children: [
			{
				path: 'profile',
				component: ProfileComponent
			},
		
			{
				path: 'registre',
				component:RegistreComponent,
				  
			},
			{
				path: 'Demande',
				component:DemandeComponent,
				
			},
			{
				path: 'historique',
				component: HistoriqueComponent,
				
				  
			},
            {
				path: 'projet',
				component: ProjectComponent,
				
				  
			},
			{
				path: 'user',
				component: UserComponent,
				
				  
			},
			{
				path: 'traiter',
				component: TraiterDemandeComponent,
				
				  
			},
		
			{
				path: 'nav',
				component: NgbdnavBasicComponent
			},
		
		]
	}
];
