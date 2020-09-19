# VIP-Admin 2

CS:GO fully automated VIP system with database synchronization. Includes manual admin list, free VIP tokens, discount coupons, VIP transfers, special VIP durations (give discounts to first buyers, higher durations to users with 1 or more orders, etc), PayPal and MercadoPago processors (anything supported by [payment-system](https://github.com/HugoJF/payment-system)) and a *somewhat* maintainable codebase (much much better than the first version).

This system is capable of handling multiple servers, multiple orders (admins database is properly synchronized, not dumped and rebuilt) and provide a complete solution for CS:GO community servers.

## How it works

The entire payment processing logic is handled by (via API) [payment-system](https://github.com/HugoJF/payment-system).

Logins are made exclusively via Steam to make sure users don't have to provide SteamIDs and making the entire process more streamlined.

After login in, a user can create as many orders as needed, [payment-system](https://github.com/HugoJF/payment-system) will webhook once it detects any payments, and the system will properly realign orders to avoid overlap.

Users also are able to transfer their orders to other accounts. A refactoring logic is executed to make sure every paid and valid orders are kept continous.

System administrators have the option to manually had new admins with any SourceMod flags. VIP-Admin-2 is **NOT** aware of servers, it only synchronizes to a single database.

## Screenshots

#### Homepage 

<p align="center">
  <img src="https://i.imgur.com/R01UxmF.png">
</p>

#### Orders

<p align="center">
  <img src="https://i.imgur.com/j9yjrqD.png">
</p>

#### User settings

<p align="center">
  <img src="https://i.imgur.com/KzQ8Nux.png">
</p>

#### Order details

<p align="center">
  <img src="https://i.imgur.com/1Oi6zHe.png">
</p>

#### Tokens

<p align="center">
  <img src="https://i.imgur.com/x4vEtc7.png">
</p>

#### Users list

<p align="center">
  <img src="https://i.imgur.com/w9aHBC5.png">
</p>

#### User details

<p align="center">
  <img src="https://i.imgur.com/4lvu2yH.png">
</p>

#### Products list

<p align="center">
  <img src="https://i.imgur.com/bhiUBex.png">
</p>

#### Admins list

<p align="center">
  <img src="https://i.imgur.com/zIbQlQL.png">
</p>


## Requirements
  - PHP 7.x
  - MySQL/MariaDB
  - Installation of [payment-system](https://github.com/HugoJF/payment-system)

## Installation
  - Deploy this Laravel app;
  - If you don't have [payment-system](https://github.com/HugoJF/payment-system), deploy it;
  - Configure your `admins` database in VIP-Admin (.env file);
  - Configure your CS:GO server to user that database;
  - Wait for the rest of the .env documentation or figure it out.
  
## Configuration
  There are no configuration options yet.

## TODO:
  - Extract some logic to service layer;
  - Remove hardcoded links;
  - Tests.
