import {Injectable} from '@angular/core';
import {Observable, ReplaySubject} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {environment} from "../../environments/environment";

const IS_READY_ENDPOINT = '/is-ready';

@Injectable({
  providedIn: 'root'
})
export class IsReadyService {

  public get isReady$() {
    return this._isReady$.asObservable()
  };

  private _isReady$: ReplaySubject<boolean> = new ReplaySubject(1);

  constructor(private httpClient: HttpClient) {
    this.loadIfIsReady();
  }

  public loadIfIsReady() {
    this.httpClient.get(environment.apiBaseUrl + IS_READY_ENDPOINT).subscribe((response: any) => {
      this._isReady$.next(response['is-ready'] ?? false);
    })
  }
}
