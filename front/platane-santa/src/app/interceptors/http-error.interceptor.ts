import {Injectable} from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor, HttpErrorResponse
} from '@angular/common/http';
import {Observable, tap} from 'rxjs';

export class HttpError {
  static BadRequest = 400;
  static Unauthorized = 401;
  static Forbidden = 403;
  static NotFound = 404;
  static TimeOut = 408;
  static Conflict = 409;
  static InternalServerError = 500;
}

@Injectable()
export class HttpErrorInterceptor implements HttpInterceptor {

  constructor() {
  }

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    return next.handle(request).pipe(
      tap({
        error: (exception) => {
          if (exception instanceof HttpErrorResponse) {
            switch (exception.status) {

              case HttpError.BadRequest:
                console.error('Bad Request 400', exception);
                break;

              case HttpError.Unauthorized:
                console.error('Unauthorized 401', exception);
                break;

              case HttpError.NotFound:
                //show error toast message
                console.error('Not Found 404', exception);
                break;

              case HttpError.TimeOut:
                // Handled in AnalyticsExceptionHandler
                console.error('TimeOut 408', exception);
                break;

              case HttpError.Forbidden:
                console.error('Forbidden 403', exception);
                break;

              case HttpError.InternalServerError:
                console.error('big bad 500', exception);
                break;

              default:
                console.error('any error', exception);
                break;
            }
          }
        }
      })
    )
  }
}
