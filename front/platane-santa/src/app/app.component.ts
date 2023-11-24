import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {AuthenticationService} from './services/authentication.service';
import {catchError, EMPTY, of, take} from 'rxjs';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  public loading = false;

  constructor(private router: Router, private authenticationService: AuthenticationService) {
  }

  public ngOnInit(): void {
    this.checkIfAuthenticated();
  }

  private checkIfAuthenticated() {
    this.loading = true;
    const token = this.authenticationService.getToken();
    if (token) {
      this.authenticationService.isAuthenticated$.pipe(
        take(1),
        catchError((err) => {
          console.error(err)
          return of(false)
        })
      ).subscribe(isAuthenticated => {
        if (!isAuthenticated) {
          this.logout();
        } else {
          // this.router.navigate(['/']);
        }
        this.loading = false;
      });

      this.authenticationService
        .refreshUser$({refreshAuthStatus: true})
        .pipe(
          catchError((err) => {
            console.error(err)
            this.authenticationService.logout();
            return of(EMPTY);
          })
        ).subscribe();
    } else {
      this.logout();
      this.loading = false;
    }
  }

  public logout() {
    this.authenticationService.logout();
    this.router.navigate(['/login']);
  }
}
