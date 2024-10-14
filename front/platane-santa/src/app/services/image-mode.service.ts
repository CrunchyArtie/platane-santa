import { Injectable } from '@angular/core';
import {ReplaySubject} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {environment} from "../../environments/environment";

const IS_IMAGE_MODE_ACTIVE_ENDPOINT = '/is-image-mode-active';

@Injectable({
  providedIn: 'root'
})
export class ImageModeService {

  public get isImageMode$() {
    return this._isImageMode$.asObservable()
  };

  private _isImageMode$: ReplaySubject<boolean> = new ReplaySubject(1);

  constructor(private httpClient: HttpClient) {
    this.loadIfIsImageMode();
  }

  public loadIfIsImageMode() {
    this.httpClient.get(environment.apiBaseUrl + IS_IMAGE_MODE_ACTIVE_ENDPOINT).subscribe((response: any) => {
      this._isImageMode$.next(response['is-image-mode-active'] ?? false);
    })
  }
}
