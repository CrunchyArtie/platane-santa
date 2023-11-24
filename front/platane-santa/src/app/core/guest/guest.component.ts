import { Component, OnInit } from '@angular/core';
import {AuthenticationService} from '../../services/authentication.service';
import {map} from 'rxjs';

@Component({
  selector: 'app-guest',
  templateUrl: './guest.component.html',
  styleUrls: ['./guest.component.scss']
})
export class GuestComponent implements OnInit {
  public isGuest$ = this.authenticationService.isAuthenticated$.pipe(map(isAuthenticated => !isAuthenticated));

  constructor(private authenticationService: AuthenticationService) { }

  ngOnInit(): void {
  }

}
