# Prueba Tenica Opcion yo

Proyecto realizado con Nuxt 3 y Laravel 11

## API Referencia

#### Obtener Empleados con horarios disponibles segun intervalo de tiempo

```http
  GET /api/employe-avalaible-horaries
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `start_time` | `date` | **Required**. Date format Y-m-d |
| `end_time` | `date` | **Required**. Date format Y-m-d |

#### Get Obtener Empleados que esten disponibles segun fecha y hora dada

```http
  GET /api/employee-avalaible
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `time_request`      | `timestamp` | **Required**. Timestamp |
| `timezone`      | `string` | **Required**. Zona horaria solicitante |

#### Obtiene datos de un empleado

```http
  GET /api/employee/{employee}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `employee`      | `uuid` | id de empleado |

#### Crear Empleado

```http
  POST /api/employees
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required** nombre |
| `last_name`      | `string` | **Required** apellido |
| `phone`      | `string` | **Required** telefono |
| `address`      | `string` | **Required** dirección |
| `speciality`      | `string` | **Required** Especialidad |
| `hour_start`      | `date` | **Required** Hora de inicio - H:i |
| `hour_end`      | `date` | **Required** Hora final - H:i|
| `lunch_start`      | `date` | **Required** Hora de Almuerzo - H:i|
| `lunch_end`      | `date` | **Required** Hora final de Almuerzo - H:i|
| `days`      | `array` | **Required** Dias de trabajo en ingles|

#### Editar Empleado

```http
  PUT /api/employees/{employee}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `employee`      | `uuid` | **Required** id del empleado a editar |
| `name`      | `string` | **Required** nombre |
| `last_name`      | `string` | **Required** apellido |
| `phone`      | `string` | **Required** telefono |
| `address`      | `string` | **Required** dirección |
| `speciality`      | `string` | **Required** Especialidad |
| `hour_start`      | `date` | **Required** Hora de inicio - H:i |
| `hour_end`      | `date` | **Required** Hora final - H:i|
| `lunch_start`      | `date` | **Required** Hora de Almuerzo - H:i|
| `lunch_end`      | `date` | **Required** Hora final de Almuerzo - H:i|
| `days`      | `array` | **Required** Dias de trabajo en ingles|

#### Crear una reservacion con un empleado

```http
  POST /api/reservations
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `employee_id`      | `uuid` | **Required** id del empleado a editar |
| `date`      | `date` | **Required** Fecha de reserva Y-m-d |
| `time`      | `timestamp` | **Required** Hora de la reserva timestamp |
| `timezone`      | `string` | **Required** Zona horaria cliente |

#### Generar reporte por intervalo tiempo horario disponible y reservados

```http
  GET /api/reservations
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `start_time`      | `date` | **Required** Fecha inicial Y-m-d |
| `end_time`      | `date` | **Required** Fecha final Y-m-d|





## Despliegue

### Requerimientos

PHP 8.2

Bun o minimo de node version 18

### Usando docker

ingresar el siguiente comando para desplegar

    docker-compose up -d



### Variables de entorno Docker
Aparte de las variable de laravel al final del .env se debe configurar las siguientes.

`NUXT_PUBLIC_API_URL` url del backend ejemplo `https://tuapibackend/api`

`DOMAIN` Dominio para el Nginx que usa el docker

`DATABASE_PORT` Puerto de la base de datos externo

`PHPMYADMIN_PORT` Puerto para y abrir el phpmyadmin

`APP_PORT` Puerto de la App frontend




