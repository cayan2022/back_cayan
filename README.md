<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## How it works
- ```cp .env.example .env```
- ```composer install```
- ```php artisan key:generate```
- put your DB env
- ```php artisan migrate:fresh --seed```
- for test ```php artisan test```

## Todos

[//]: # (- [ ] &#40;for unchecked checkbox&#41;)

[//]: # (- [X] &#40;for checked checkbox&#41;)
### Nasr
- [ ] discus app table in permissions seeder
- [ ] translate role and permissions using __() function
- [ ] add filters to models not use it
- [ ] change all is_active to is_block 
- [ ] add HasActivation trait to all models has is_block attribute
