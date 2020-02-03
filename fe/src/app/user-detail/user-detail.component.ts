import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { users } from "../users";
import { CartService } from "../cart.service";

@Component({
             selector: 'app-user-detail',
             templateUrl: './user-detail.component.html',
             styleUrls: ['./user-detail.component.css']
           })
export class UserDetailComponent implements OnInit {
  user;

  constructor(private route: ActivatedRoute, private cartService: CartService) {
  }

  addToCart(user) {
    window.alert('your user has been added to the cart!');
    this.cartService.addToCart(user);
  }

  ngOnInit() {
    this.route.paramMap.subscribe(params => {
      this.user = users[+params.get('userId')]
    });
  }

}
