#   <p align="center" style="color:#b5a600"> authorize api token for mongodb </p>


## install For laravel 9.x use
``` bash
 composer require mostafamaklad/laravel-permission-mongodb
 
 ```

``` bash
 composer require esperlos98/esaccess
```
## You can publish the migration with:

``` bash
php artisan vendor:publish --provider="Maklad\Permission\PermissionServiceProvider" --tag="migrations"   
```

``` bash
php artisan migrate
```

You can publish the config file with:

``` bash
php artisan vendor:publish --provider="Maklad\Permission\PermissionServiceProvider" --tag="config"
```

## When published, the config/permission.php config file contains:

``` bash 
return [

    'models' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Moloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Maklad\Permission\Contracts\Permission` contract.
         */

        'permission' => Maklad\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Moloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Maklad\Permission\Contracts\Role` contract.
         */

        'role' => Maklad\Permission\Models\Role::class,

    ],

    'collection_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',
    ],

    /*
     * By default all permissions will be cached for 24 hours unless a permission or
     * role is updated. Then the cache will be flushed immediately.
     */

    'cache_expiration_time' => 60 * 24,

    /*
     * By default we'll make an entry in the application log when the permissions
     * could not be loaded. Normally this only occurs while installing the packages.
     *
     * If for some reason you want to disable that logging, set this value to false.
     */

    'log_registration_exception' => true,
    
    /*
     * When set to true, the required permission/role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */
    
    'display_permission_in_exception' => false,
];
``` 

# Usage

## First, add the Maklad\Permission\Traits\HasRoles trait to your User model(s):

``` bash
use Illuminate\Auth\Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Maklad\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasRoles;

    // ...
}
```


Note: that if you need to use HasRoles trait with another model ex.Page you will also need to add protected $guard_name = 'web'; as well to that model or you would get an error

``` bash 
use Jenssegers\Mongodb\Eloquent\Model as Model;
use Maklad\Permission\Traits\HasRoles;

class Page extends Model
{
    use HasRoles;

    protected $guard_name = 'web'; // or whatever guard you want to use

    // ...
}
```
# useing can 
Saved permissions will be registered with the Illuminate\Auth\Access\Gate class for the default guard. So you can test if a user has a permission with Laravel's default can function:

``` bash 
    $user->can('edit articles');
```

# Using a middleware

<p> This package comes with RoleMiddleware and PermissionMiddleware middleware. You can add them inside your app/Http/Kernel.php file.
</p>

``` bash 
protected $routeMiddleware = [
    // ...
    'role' => \Maklad\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Maklad\Permission\Middlewares\PermissionMiddleware::class,
];

```
<p> Then you can protect your routes using middleware rules: </p>

``` bash
Route::group(['middleware' => ['role:super-admin']], function () {
    //
});

Route::group(['middleware' => ['permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role:super-admin','permission:publish articles']], function () {
    //
});
```

# Using artisan commands

You can create a role or permission from a console with artisan commands.

``` bash
php artisan permission:create-role writer
```

``` bash
php artisan permission:create-permission 'edit'

```

When creating permissions and roles for specific guards you can specify the guard names as a second argument:

```  bash 
php artisan permission:create-role writer yourGuards
```

## create user defulte

#### role

``` bash
php artisan permission:create-role "admin" apiMongo

```
#### permission

``` bash
php artisan permission:create-permission "user edit" apiMongo

```

#### user assign to admin

``` bash
 php artisan userAdmin:install  "userId"

```

## Routings
> ### for create role
> <p>yourdomine/api/es/v1/createRole</p>
> <p>parameters : role</p>

> ### for create permission
> <p>yourdomine/api/es/v1/createPermission</p>
> <p>parameters : permission</p>

> ### for assign role to permission
> <p>yourdomine/api/es/v1/assignRoleToPermission</p>
> <p>parameters : role_id , permission_ids</p>
#### example permission_ids json
``` bash 
{"ids":["62bbd2a45898f83b7905f813","62bbd092b9fa8fc76f011182"]}
```
> ### for assign role to user
> <p>yourdomine/api/es/v1/assignUser</p>
> <p>parameters : user_id , role_ids</p>
#### example role_ids json
``` bash 
{"ids":["62bbd2a45898f83b7905f813","62bbd092b9fa8fc76f011182"]}
```
> ### for sync role or delete and update
> <p>yourdomine/api/es/v1/syncRole</p>
> <p>parameters : user_id , role_ids</p>
#### example role_ids json
``` bash 
{"ids":["62bbd2a45898f83b7905f813","62bbd092b9fa8fc76f011182"]}
```
> ### for sync permission or delete and update
> <p>yourdomine/api/es/v1/syncPermission</p>
> <p>parameters : user_id , permission_ids</p>
#### example permission_ids json
``` bash 
{"ids":["62bbd2a45898f83b7905f813","62bbd092b9fa8fc76f011182"]}
```
