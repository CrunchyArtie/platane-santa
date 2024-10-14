import { Injectable } from '@angular/core';
import {ReplaySubject} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {environment} from "../../environments/environment";

const SANTA_JOKE_TARGET_ENDPOINT = '/santa-joke-target';

@Injectable({
  providedIn: 'root'
})
export class SantaJokeTargetService {

  public get santaJokeTarget$() {
    return this._santaJokeTarget$.asObservable()
  };

  private _santaJokeTarget$: ReplaySubject<boolean> = new ReplaySubject(1);

  constructor(private httpClient: HttpClient) {
    this.loadIfIsReady();
  }

  public loadIfIsReady() {
    this.httpClient.get(environment.apiBaseUrl + SANTA_JOKE_TARGET_ENDPOINT).subscribe((response: any) => {
      this._santaJokeTarget$.next(response['santa-joke-target'] ?? false);
    })
  }
}
