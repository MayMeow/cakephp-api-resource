# Cakephp Api Resource

[![Beerpay](https://beerpay.io/MayMeow/cakephp-api-resource/badge.svg)](https://beerpay.io/MayMeow/cakephp-api-resource)
[![Build Status](https://travis-ci.org/MayMeow/cakephp-api-resource.svg?branch=master)](https://travis-ci.org/MayMeow/cakephp-api-resource)

JSON API Resource plugin for CakePHP. This plugin is inspired with laravel's JSON API resources.

## Requirements

* CakePHP 3.6
* PHP 7.1 or greater

## Installation

Cakephp Api Resource plugin can be installed with Composer

```bash
composer require maymeow/cakephp-api-resource
```

## Usage

### Creating resources

In this example ill show how to create UserResource. In your application create new file `src/Http/Resources/UserResource.php`.

**UserResource.php** will looks like this:

```php
<?php
namespace App\Http\Resources;

use MayMeow\API\Resource;

class UserResource extends Resource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => $this->created
        ];
    }
}
```

Next you can use your newly created resource in your api controller. Example below:

```php
<?php
// ...
use App\Http\Resources\UserResource;
// ... class definition above
 public function index()
    {
        $query = $this->Users->find();

        $users = UserResource::collection($query);

        $this->set([
            'users' => $users,
            '_serialize' => ['users']
        ]);
    }
```

### Single vs collection of resources

If you getting one instance of entity for example `$this->Users->get($id)` use:

```php
// BelongsTo, HasOne
$user = (new UserResource($userQuery))->get();
```

If you getting more instances for example index `$allUsers = $this->Users->find()` use:

```php
// HasMany, HasAndBelongsToMany
$users = UserResource::collection($query);
```

### Anonymous functions

In cas you will need update properties before send them to client resources support anonymous functions. Following example show how to send html generated from 
markdown:

in your resource file

```php
public function toArray()
    {
        return [
            'id' => $this->id,
            'raw_body' => $this->text,
            'html_body' => function ($q) {
                return (new Parsedown())->$text($q->text); // text is parsed before data is send to client
            }
        ];
    }
```

### Associations beta

Resources can include each other.

```php
public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'profile' => function ($q) {
                return (new ProfileResource($q->profile))->get(); // single entity (belongsTo, HasOne)
            },
            'posts' => function ($q) {
                return PostResource::collection($q->posts); // collection of resources (hasMany)
            }
        ];
    }
```

Known bug: In beta **do not** include same association because in cause neverending loop.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

SEE changelog

## Credits

* MayMeow

## License

MIT