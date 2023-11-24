import {Component, OnInit} from '@angular/core';
import {FormBuilder, Validators} from '@angular/forms';
import {AuthenticationService} from '../../services/authentication.service';
import {catchError, of, ReplaySubject} from 'rxjs';
import {Router} from '@angular/router';
import {get} from 'lodash-es';

@Component({
  selector: 'app-register-page',
  templateUrl: './register-page.component.html',
  styleUrls: ['./register-page.component.scss']
})
export class RegisterPageComponent implements OnInit {

  public registerForm = this.formBuilder.group({
    email: ['', [Validators.required, Validators.minLength(3)]],
    name: ['', [Validators.required, Validators.minLength(3)]],
    password: ['', [Validators.required]],
    password_confirmation: ['', [Validators.required]]
  });
  public loading = false;
  private genericErrors = {
    required: 'Ce champ est requis',
    minlength: 'Ce champ doit contenir au moins 3 caractères'
  };
  private backendErrors: { [control: string]: { [error: string]: string } } = {};
  public isRegisterActive$ = this.authenticationService.isRegisterActive();

  constructor(
    private formBuilder: FormBuilder,
    private authenticationService: AuthenticationService,
    private router: Router
  ) {
  }

  ngOnInit(): void {
    this.authenticationService.checkCsrfToken().subscribe();
  }

  public onSubmit() {
    if (this.registerForm.valid) {
      this.loading = true;

      this.authenticationService
        .register(this.registerForm.value)
        .pipe(
          catchError((error) => {
              this.backendErrors = error?.error?.errors || {};
              for (let backendErrorsKey in this.backendErrors) {
                const errors = Object.keys(this.backendErrors[backendErrorsKey]);

                this.registerForm.get(backendErrorsKey)?.setErrors(
                  errors.reduce((acc, error) => ({...acc, [error]: true}), {})
                );
              }
              return of(null);
            }
          ))
        .subscribe((response) => {
          if (response !== null) {
            this.router.navigate(['/']);
          }
          this.loading = false;
        });
    }
  }

  public getErrors(control: string) {
    return {
      ...this.genericErrors,
      ...get(this.backendErrors, control, {})
    };

  }
}
