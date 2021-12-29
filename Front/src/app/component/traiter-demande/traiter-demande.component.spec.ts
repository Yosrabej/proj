import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TraiterDemandeComponent } from './traiter-demande.component';

describe('TraiterDemandeComponent', () => {
  let component: TraiterDemandeComponent;
  let fixture: ComponentFixture<TraiterDemandeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TraiterDemandeComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TraiterDemandeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
