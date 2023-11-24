import { Component, OnInit } from '@angular/core';
import {AuthenticationService} from '../../services/authentication.service';

@Component({
  selector: 'app-authenticated',
  templateUrl: './authenticated.component.html',
  styleUrls: ['./authenticated.component.scss']
})
export class AuthenticatedComponent implements OnInit {
  public isAuthenticated$ = this.authenticationService.isAuthenticated$;

  constructor(private authenticationService: AuthenticationService) { }

  ngOnInit(): void {
  }

}
