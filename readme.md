# Server
A Laravel 5.3 Server for serving API DATA
* Laravel v5.3
* JWT Token Based Auth (crypted token) `"tymon/jwt-auth": "0.5.*"`

## Note to Apache users

Apache seems to discard the Authorization header if it is not a base64 encoded user/pass combo. So to fix this you can add the following to your apache config

```
RewriteEngine On
RewriteCond %{HTTP:Authorization} ^(.*)*
RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
```

## Official Laravel Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).