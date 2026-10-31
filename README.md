# Laravel Boilerplate

> An opinionated boilerplate for Laravel and Inertia, using Vue 3. Includes authentication, authorization
> and passkey support.
>
> This boilerplate houses a built-in user manager, role and permission manager, application settings
> manager, passkeys support, and custom `artisan` commands. It uses `element-plus` for the interface
> and auto-imports for most aspect of frontend development.
>
> Also included, is a litany of different Laravel helpers, enums and traits, and frontend composables and
> components and custom error handling. All this (and much more) is included in an effort to make developing a Laravel
> and Inertia application much smoother and much faster.

## Setup

```bash
$ cp .env.example .env
```

```bash
$ php artisan key:generate
```

```bash
$ php artisan storage:link
```

```bash
$ php artisan migrate:fresh --seed
```

## Custom Commands

`clear:inertia`
> Clears `storage/inertia-devtools`

```bash
php artisan clear:inertia

```

`clear:debugbar`
> Clears `storage/debugbar`

```bash
php artisan clear:debugbar
```

`clear:views`
> Clears `storage/framework/views`

```bash
php artisan clear:views
```

`optimize:all`
> Runs all the commands above, alongside `php artisan optimize:clear`

```bash
php artisan optimize:all
```
