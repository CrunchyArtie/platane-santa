import {Component, inject, OnInit} from '@angular/core';
import {AuthenticationService} from '../../services/authentication.service';
import {mergeMap, Observable} from "rxjs";
import {IsReadyService} from "../../services/is-ready.service";
import * as fs from "fs";
import {HttpClient} from "@angular/common/http";
import {environment} from "../../../environments/environment";
import {Image} from "../../models/image";

const IMAGE_ENDPOINT = '/images';

@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.scss']
})
export class LandingPageComponent implements OnInit {

  private authenticationService = inject(AuthenticationService)
  private isReadyService = inject(IsReadyService)
  private httpClient = inject(HttpClient)

  public user$ = this.authenticationService.user$;
  public isReady$: Observable<boolean> = this.isReadyService.isReady$;
  public showErrorMessage = false;

  public onFileSelected(event: any): void {
    const selectedFile = event.target.files[0];
    this.showErrorMessage = false;

    if (selectedFile) {
      const formData = new FormData();
      formData.append('image', selectedFile);

      this.httpClient.post(environment.apiBaseUrl + IMAGE_ENDPOINT, formData)
        .pipe(
          mergeMap(() => this.authenticationService.refreshUser$({refreshAuthStatus: true}))
        )
        .subscribe({
          error: error => {
            this.showErrorMessage = true;
          }
        });
    }
  }

  ngOnInit(): void {
  }

  getImagePath(image: Image) {
    return environment.apiBaseUrl + IMAGE_ENDPOINT + '/' + image.id;
  }

  userImagesOrNull(images: Image[]) {
    const myImages = [];

    for (let i = 1; i >= 0; i--) {
      if (images[i]) {
        myImages.push(images[i]);
      } else {
        myImages.push(null);
      }
    }
    return myImages;
  }

  deleteImage(image: Image) {
    this.httpClient.delete(environment.apiBaseUrl + IMAGE_ENDPOINT + '/' + image.id)
        .pipe(
          mergeMap(() => this.authenticationService.refreshUser$({refreshAuthStatus: true}))
        )
      .subscribe({
        error: error => {
          this.showErrorMessage = true;
        }
      });
  }
}
