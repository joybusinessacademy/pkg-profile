# About JBA Profile

JBA Profile is a Laravel package to manage user's profile and relevant data ...

## Installation

Use composer to install

```bash
composer require joybusinessacademy/pkg-profile
```
For Windows OS, please use parameter --ignore-platform-reqs

## Usage

Publish vendor migration, config and seeder files

```bash
php artisan vendor:publish --provider="JoyBusinessAcademy\Profile\ProfileServiceProvider"
```

When published, the ```config/jba-profile.php``` initially contains

We use `Gateway Pattern` to organize all functionality, please extends the JoyBusinessAcademy\Profile\ProfileGateway to customize your own gateway

```gateway => \JoyBusinessAcademy\Profile\ProfileGateway::class```
 
The model you want to use as a Profile model needs to implement the JoyBusinessAcademy\Profile\Models\Profile contract
 
```models.profile => JoyBusinessAcademy\Profile\Models\Profile```

The model you want to use as a Region model needs to implement the JoyBusinessAcademy\Profile\Models\Region contract 

```models.region => JoyBusinessAcademy\Profile\Models\Region```

The model you want to use as a User model needs to use JoyBusinessAcademy\Profile\Traits\HasProfile trait

```models.region => JoyBusinessAcademy\Profile\Models\User```

We have chosen a default table names but you may easily change it to any table you like

```table_names.profiles => 'profiles'```

```table_names.regions => 'regions'```

```table_names.users => 'users'```

We use `Repository Pattern` to separate business logic with data layer, please extends the JoyBusinessAcademy\Profile\Repositories\ProfileRepository to customize your own repository

```repostories.profile => \JoyBusinessAcademy\Profile\Repositories\ProfileRepository::class```

Run Region Seeder

``` php artisan db:seed --class=RegionSeeder ```

## Contributing


## License

[MIT](https://choosealicense.com/licenses/mit/)