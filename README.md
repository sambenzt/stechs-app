## Laravel Docker

Pasos para correr el proyecto usando docker.

## Configurar el alias

```sh
alias sail='bash vendor/bin/sail'
```

## Configuración de entorno 

Copiar el archivo .env.example a .env y configurar las variables

```sh
APP_PORT=80
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```


## Correr el proyecto

```sh
cd /.../path/stechs-app
```

Correr los contenedores de docker y levantar el proyecto en el puerto configurado en APP_PORT,
por defecto http://localhost:80 

```sh
sail up -d
```

## Cargar la base de datos

Ingresar al contenedor 

```sh
sail bash
```

Importar el archivo database.sql a la base de datos creada en el primer paso

```sh
mysql -h mariadb -u root -p laravel < database.sql 
```

## Correr los tests
```sh
sail test
```
