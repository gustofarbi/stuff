import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from "@angular/common/http";

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UserListComponent } from './user-list/user-list.component';
import { TopBarComponent } from './top-bar/top-bar.component';
import { RouterModule } from "@angular/router";
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { UserAlertsComponent } from './user-alerts/user-alerts.component';
import { ReactiveFormsModule } from "@angular/forms";
import { UserDetailComponent } from "./user-detail/user-detail.component";
import { CartComponent } from './cart/cart.component';
import { ShippingComponent } from './shipping/shipping.component';

@NgModule({
  declarations: [
    AppComponent,
    UserListComponent,
    UserDetailComponent,
    TopBarComponent,
    UserAlertsComponent,
    CartComponent,
    ShippingComponent,
  ],
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    AppRoutingModule,
    RouterModule.forRoot([
      { path: '', component: UserListComponent },
      { path: 'users/:userId', component: UserDetailComponent },
      { path: 'cart', component: CartComponent },
      { path: 'shipping', component: ShippingComponent }
    ]),
    BrowserAnimationsModule,
    HttpClientModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
