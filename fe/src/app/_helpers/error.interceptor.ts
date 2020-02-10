import { Injectable } from "@angular/core";
import { AuthentificationService } from "../authentification.service";
import { HttpEvent, HttpHandler, HttpRequest } from "@angular/common/http";
import { Observable, throwError } from "rxjs";
import { catchError } from "rxjs/operators";

@Injectable({providedIn: "root"})
export class ErrorInterceptor {
  constructor(private authenticationService: AuthentificationService) {
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      if (err.status === 401) {
        this.authenticationService.logout();
        location.reload();
      }

      const error = err.error.message || err.statusText;
      return throwError(error);
    }))
  }
}
