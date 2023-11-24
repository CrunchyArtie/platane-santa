import {Injectable} from '@angular/core';
import {map, ReplaySubject} from 'rxjs';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {RawUserData, User} from '../models/user';

const REGISTER_ENDPOINT = '/register';
const LOGIN_ENDPOINT = '/login';
const ME_ENDPOINT = '/user';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  public isAuthenticated$ = new ReplaySubject<boolean>(1);
  public user$ = new ReplaySubject<User | null>(1);

  constructor(private httpClient: HttpClient) {

  }

  public register(value: Partial<{ email: string | null, password: string | null, password_confirmation: string | null, reindeer: string | null }>) {
    return this.httpClient
      .post<{ user: any; token: string }>(environment.apiBaseUrl + REGISTER_ENDPOINT, value)
      .pipe(map((response: any) => {
        this.setUser(response?.user);
        this.setToken(response?.token);
        this.isAuthenticated$.next(true);
        return response;
      }))
  }

  public login(value: Partial<{ email: string | null, password: string | null }>) {
    return this.httpClient
      .post<{ user: any; token: string }>(environment.apiBaseUrl + LOGIN_ENDPOINT, value)
      .pipe(map((response) => {
        this.setUser(response?.user);
        this.setToken(response?.token);
        this.isAuthenticated$.next(true);
        return response;
      }))
  }

  public getToken() {
    return JSON.parse(localStorage.getItem('auth_token')!);
  }

  public refreshUser$({refreshAuthStatus}: { refreshAuthStatus: boolean } = {refreshAuthStatus: false}) {
    return this.httpClient
      .get<RawUserData & {target: RawUserData}>(environment.apiBaseUrl + ME_ENDPOINT)
      .pipe(map(response => {
        this.setUser(response!)
        if (refreshAuthStatus) {
          this.isAuthenticated$.next(true);
        }
      }));
  }

  public logout() {
    localStorage.removeItem('auth_token');
    this.user$.next(null);
    this.isAuthenticated$.next(false);
  }

  private setUser(responseElement: RawUserData & {target: RawUserData}) {
    this.user$.next(new User(responseElement));
  }

  private setToken(token: string) {
    localStorage.setItem('auth_token', JSON.stringify(token));
  }

  public checkCsrfToken() {
    return this.httpClient.get(environment.csrfUrl, {observe: 'response'})
  }

  public isRegisterActive () {
    return this.httpClient.get<{is_registration_open: boolean}>(environment.apiBaseUrl + '/is_registration_open').pipe(
      map(response => response?.is_registration_open)
    );
  }

}
