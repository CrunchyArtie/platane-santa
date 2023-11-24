import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {LoginPageComponent} from './pages/login-page/login-page.component';
import {LandingPageComponent} from './pages/landing-page/landing-page.component';
import {RegisterPageComponent} from './pages/register-page/register-page.component';
import {APP_BASE_HREF} from '@angular/common';
import {HTTP_INTERCEPTORS, HttpClientModule, HttpClientXsrfModule} from '@angular/common/http';
import {HttpXsrfInterceptor} from './interceptors/http-xsrf.interceptor';
import {HttpErrorInterceptor} from './interceptors/http-error.interceptor';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatButtonModule} from '@angular/material/button';
import {MatIconModule} from '@angular/material/icon';
import {MatCardModule} from '@angular/material/card';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatInputModule} from '@angular/material/input';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {Router} from '@angular/router';
import {throttleTime} from 'rxjs';
import {CustomInputComponent} from './core/custom-input/custom-input.component';
import {ReplacePipe} from './pipes/replace.pipe';
import {HttpJwtInterceptor} from './interceptors/http-jwt.interceptor';
import {AuthenticatedComponent} from './core/authenticated/authenticated.component';
import {GuestComponent} from './core/guest/guest.component';
import {MatProgressSpinnerModule} from '@angular/material/progress-spinner';
import { ResolvePageComponent } from './pages/resolve-page/resolve-page.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginPageComponent,
    LandingPageComponent,
    RegisterPageComponent,
    CustomInputComponent,
    ReplacePipe,
    AuthenticatedComponent,
    GuestComponent,
    ResolvePageComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    MatCardModule,
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatCheckboxModule,
    MatProgressSpinnerModule,
    HttpClientXsrfModule.withOptions({cookieName: 'XSRF-TOKEN', headerName: 'X-XSRF-TOKEN'}),
    FormsModule
  ],
  providers: [
    {provide: APP_BASE_HREF, useValue: '/'},
    {provide: HTTP_INTERCEPTORS, useClass: HttpXsrfInterceptor, multi: true},
    {provide: HTTP_INTERCEPTORS, useClass: HttpJwtInterceptor, multi: true},
    {provide: HTTP_INTERCEPTORS, useClass: HttpErrorInterceptor, multi: true}
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
  constructor(
    private router: Router
  ) {
    this.router
      .events
      .pipe(
        throttleTime(500)
      ).subscribe(() => {
      this.shuffleBackground();
    });
  }

  private shuffleBackground() {
    const oldUrl = document.body.style.backgroundImage
    let newUrl = oldUrl;
    do {
      const id = Math.round(Math.random() * 9);
      newUrl = `url("assets/backgrounds/reindeer${id}.png")`;
    } while (newUrl === oldUrl);
    document.body.style.backgroundImage = newUrl;


    const oldSize = document.body.style.backgroundSize
    let newSize = oldSize;
    do {
      const size = 0.75 * (20 + Math.round(Math.random() * 9));
      newSize = `${size}%, ${size}%`;
    } while (newSize === oldSize);
    document.body.style.backgroundSize = newSize;

  }
}
