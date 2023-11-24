import {Component, OnInit} from '@angular/core';
import {FormBuilder, Validators} from '@angular/forms';
import {AuthenticationService} from '../../services/authentication.service';
import {catchError, of} from 'rxjs';
import {Router} from '@angular/router';
import {get} from 'lodash-es';

@Component({
  selector: 'app-login-page',
  templateUrl: './login-page.component.html',
  styleUrls: ['./login-page.component.scss']
})
export class LoginPageComponent implements OnInit {

  public loginForm = this.formBuilder.group({
    email: ['', [Validators.required]],
    password: ['', [Validators.required]]
  });
  public loading = false;
  private genericErrors = {
    required: 'Ce champ est requis'
  };
  private backendErrors: { [control: string]: { [error: string]: string } } = {};

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
    if (this.loginForm.valid) {
      this.loading = true;
      this.authenticationService
        .login(this.loginForm.value)
        .pipe(
          catchError((error) => {
              this.backendErrors = (error?.error?.errors ?? {});

              for (let backendErrorsKey in this.backendErrors) {
                const errors = Object.keys(this.backendErrors[backendErrorsKey]);

                this.loginForm.get(backendErrorsKey)?.setErrors(
                  errors.reduce((acc, error) => ({...acc, [error]: true}), {})
                );
              }
              return of(null);
            }
          ))
        .subscribe((response) => {
            console.log('here')
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
