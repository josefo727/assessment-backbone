# Instrucciones para levantar en modo dev (local) con Laravel Sail

1. Clonar el repositorio en su máquina local.
2. Ejecutar el comando `composer install`.
3. Crear un archivo .env con las variables de entorno necesarias para su entorno de desarrollo. Puede usar el archivo .env.example como base.
4. Ejecutar el comando `./vendor/bin/sail up` para levantar el entorno de desarrollo.
5. Ejecutar el comando `./vendor/bin/sail artisan migrate --seed` para ejecutar las migraciones y seeders.

# Descripción del proyecto (Assessment Backbone)

El proyecto consiste en una API REST que devuelve información sobre códigos postales en México. La API está construida con Laravel y se comunica con una base de datos MySQL. La información de los códigos postales se obtiene de una tabla previamente poblada en la base de datos.

El proyecto cuenta con un conjunto de pruebas que se pueden ejecutar para validar el correcto funcionamiento de la API. Las pruebas incluyen:

- Pruebas de migraciones y seeders para asegurarse de que la base de datos está correctamente poblada.
- Pruebas unitarias para validar la respuesta de la API para diferentes códigos postales.
- Pruebas de integración para validar la integridad de la respuesta de la API y la validación de la estructura de la respuesta.
- Pruebas de rendimiento para validar el tiempo de respuesta de la API.

Además, se han tomado medidas para optimizar el código y evitar la repetición de registros en la base de datos.

# Detalles de las pruebas

## Pruebas de migraciones y seeders

Las pruebas de migraciones y seeders se ejecutan automáticamente cuando se ejecuta el comando `./vendor/bin/sail artisan test`. Estas pruebas aseguran que la estructura de la base de datos sea correcta.

## Pruebas unitarias

Las pruebas unitarias se ejecutan automáticamente cuando se ejecuta el comando `./vendor/bin/sail artisan test`. Estas pruebas validan la respuesta de la API para diferentes códigos postales y aseguran que la información devuelta por la API sea correcta.

## Pruebas de integración

Las pruebas de integración se ejecutan automáticamente cuando se ejecuta el comando `./vendor/bin/sail artisan test`. Estas pruebas validan la integridad de la respuesta de la API y la validación de la estructura de la respuesta.

## Pruebas de rendimiento

Las pruebas de rendimiento se ejecutan automáticamente cuando se ejecuta el comando `./vendor/bin/sail artisan test`. Estas pruebas validan el tiempo de respuesta de la API y aseguran que la API responda en menos de 300 ms para cualquier código postal.

Además, se han tomado medidas para optimizar el código y evitar la repetición de registros en la base de datos. Se ha creado un helper `normalize()` que se encarga de normalizar los valores de las cadenas de caracteres, y se ha creado un recurso `ZipCodeResource` que se encarga de formatear la respuesta de la API. También se han optimizado con upsert de los seeders para que su costo en unidades de tiempo no sea tan alto, así como una validación extra para no repetir registros al insertarlos masivamente en la base de datos.

![Batería de Tests](/public/unit-tests.jpeg)

### Prueba desde el navegador
![Browser Test](/public/browser-test.png)

### Prueba desde postman
![Batería de Tests](/public/postman-test.png)

### Pruebas en línea

Url de pruebas: https://backbone.jose-gutierrez.com/api/zip-codes/{zip_code}

Ejemplo: [https://backbone.jose-gutierrez.com/api/zip-codes/01020](https://backbone.jose-gutierrez.com/api/zip-codes/01020)

API original: [https://jobs.backbonesystems.io/api/zip-codes/01020](https://jobs.backbonesystems.io/api/zip-codes/01020)

#### Mejora

##### Api original devuelve error 500 cuando se consulta un ZipCode no existente

API original: [https://jobs.backbonesystems.io/api/zip-codes/not-found](https://jobs.backbonesystems.io/api/zip-codes/not-found)
![Resultado](/public/original-not-found.png)

#### La API construída nos devuelve un 404 con un mensaje

API construída: [https://backbone.jose-gutierrez.com/api/zip-codes/not-found](https://backbone.jose-gutierrez.com/api/zip-codes/not-found)
![Resultado](/public/built-not-found.png)
