import { Component, OnInit } from "@angular/core";
import { FormBuilder , Validators  } from "@angular/forms";
import { Registre } from "../../registre";
import { RegistreService } from "./registre.service";



@Component({
  selector: 'app-registre',
  templateUrl: 'registre.component.html'
})
export class RegistreComponent implements OnInit {

 
  unamePattern = "^[a-zA-Z '-]{0,10}$";
  err :  any ;

  registre: Registre = {
    nom: '',
    prenom: '',
    email: '',
    password: '',
    roles: '',
    typecontrat: '',
   
  };

  addRegistreForm: any;
  constructor(private formBuilder: FormBuilder ,  private demandeService: RegistreService) { }

  ngOnInit(): void {
    
    this.addRegistreForm = this.formBuilder.group({
      nom: ['', [Validators.required, Validators.maxLength(20)]],
      prenom: ['' , [ Validators.required , Validators.maxLength(20)]],
      email: ['' , [Validators.required]],
      password: ['' , [Validators.required , Validators.minLength(6)]],
      roles: ['' , Validators.required],
      typecontrat: ['' , Validators.required],
      remember: true
      
    })
    //this.addRegistreForm.mustMatch('password', 'confirmPassword')
  }
  

  addRegistre() {
    console.log(this.addRegistreForm.value);
    //let registre = this.addRegistreForm.value;
    //registre['roles']= [this.selectOptionAdmin];
    //this.$test.push(this.selectOptionAdmin);
    this.demandeService.addRegistre(this.addRegistreForm.value).subscribe(
      (res: any) => {
        console.log("nom",res['nom']);
        console.log("prenom",res['prenom']);
        console.log("email",res['email']);
        console.log("password",res['password']);
        console.log("roles",res['roles']);
        console.log("type contrat",res['typecontrat']);
        window.alert('Demande bien envoyer');
      },
      (err: any) => {
        console.log(err);
        window.alert("L'email est déja utilisé");
      }
    )
}



}