<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 🚀 Current features
- Simple CRUD for `User` entity.
- Set up a simple domain driven design structure.

## 📘 Introduction
This is a simple project for apply domain driven design in Laravel.
In this project, i try to apply the DDD concept in Laravel, and i use the mapper, dto and repository pattern to make the code more clean and easy to maintain.

Some of my inspirations have been these remarkable articles:

- [Laravel DDD by Orphail](https://github.com/Orphail/laravel-ddd/tree/master).

## 🤔 Why use this approach?

Okay, let’s suppose that you want to program an app with Laravel that you expect to be mid-to-large size. You may have been working on some of these big projects but dealt with bloated controllers, monstrous models, etc. So for this one, you want to keep your sanity.

You hear about clean architecture and would like to try it, but its practices kind of break with the Laravel Way™ of building things, so either you have to stick with Laravel or create almost all the core functionalities with that permanent feeling of reinventing the wheel at every step.

I don’t have a perfect solution for this, and I haven’t heard of anyone having it, but I found a way that allows me to build things by having a more controlled planning and structure of my project despite having to deal with some extra boilerplate.

## 📁 Structure particularities

- **app/Object/Domain**: This is where the domain logic is stored. It’s divided into three main folders: Entities, Repositories, and Services.
- **app/Object/Presentation/Http/Controllers**: This is where the controllers are stored. They are responsible for handling the HTTP requests and responses.
- **app/Object/Presentation/Http/Requests**: This is where the form requests are stored. They are responsible for validating the incoming requests.
- **app/Object/Presentation/Routes**: This is where the routes are stored. They are responsible for mapping the HTTP requests to the controllers for each object.
- **app/Object/Infrastructure**: This is where the infrastructure logic is stored. It’s divided into two main folders: Providers, Mappers and Repositories.
- **app/Application**: This is where the application logic is stored. It’s divided into two main folders: DTOs and Mappers.
- **app/Application/UseCases**: This is where the use cases are stored. They are responsible for orchestrating the domain logic and the infrastructure logic.

The main structure is like this:

```
...
├── User (Object)
│   ├── Domain
│   │   ├── Models/Entities
│   │   ├── Repositories
│   │   └── Services
│   ├── Application
│   │   ├── DTOs
│   │   ├── Mappers
│   │   └── UseCases
│   ├── Presentation
│   │   ├── Http
│   │   │   ├── Controllers
│   │   │   ├── Requests
│   │   ├── Routes
│   │   ├── Trait
│   └── Infrastructure
│       ├── Mappers
│       ├── Providers
│       └── Repositories
...
```

## 📦 Installation
1. ```composer install```
2. ```cp .env.example .env```
3. ```php artisan key:generate```
4. (optional) Set database connection in the ```.env``` variables that start with ```DB_*``` and run ```php artisan migrate```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
