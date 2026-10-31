# Installation
> An opinionated boilerplate for Laravel. Includes authentication, authorization and passkey support.
> 
> This boilerplate houses a built-in user manager, role and permission manager, application settings
> manager, passkeys support, and custom `artisan` commands. It uses `element-plus` for the interface
> and auto-imports for most aspect of frontend development.

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
