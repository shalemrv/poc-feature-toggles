# Project and Invoice Creation Backend

Postman collection can be found in the codebase.

> Add an environment variable in Postman
> 
> `BASE` = `http://127.0.0.1:8000`

| Entity        | Operations    |
| ------------- | ------------- |
| Projects      | CRUD          |
| Invoices      | -R--          |
| FeatureFlags  | CRUD          |
________
### Setup Instructions

```console
  composer install
```

```console
  php app/console doctrine:database:create
```

```console
  php app/console doctrine:schema:create
```

```console
  php app/console doctrine:fixtures:load
```

```console
  php app/console server:run
```
