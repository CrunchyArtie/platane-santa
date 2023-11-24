import {Component, OnInit} from '@angular/core';
import {AuthenticationService} from '../../services/authentication.service';
import {filter, map, Observable} from 'rxjs';
import {RawUserData} from '../../models/user';
import {RawImageData} from "../../models/image";
import {environment} from "../../../environments/environment";

const IMAGE_ENDPOINT = '/images';

@Component({
  selector: 'app-resolve-page',
  templateUrl: './resolve-page.component.html',
  styleUrls: ['./resolve-page.component.scss']
})
export class ResolvePageComponent implements OnInit {
  public active = false;
  public target$: Observable<RawUserData> = this.authenticationService
    .user$
    .pipe(
      filter(user => !!user),
      map(user => user!.target)
    )

  constructor(private authenticationService: AuthenticationService) {
  }

  ngOnInit(): void {
  }

  getImagePath(image: RawImageData) {
    return environment.apiBaseUrl + IMAGE_ENDPOINT + '/' + image.id;
  }
}
