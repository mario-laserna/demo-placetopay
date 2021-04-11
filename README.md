# Demo - integración pasarela de pagos PlacetoPay 

Web application basada en Laravel. Evertec (PlacetoPay)'s technical assestment


## Instrucciones

### Setup del proyecto

Por favor descargue o clone este repositorio, una vez lo haya hecho, al ser un proyecto laravel, por favor ejecute
`composer update`

Para ejecutar las migraciones y seeder por favor ejecute
`php artisan:migrate --seed`

### Usuario
El listado de órdenes lo dejé sin acceso público, por lo que se hace necesario loguearse primero, para esto 
puede usar el usuario de prueba mario@test.com y contraseña test2021 en la url `http://site/login`

### Variables de entorno
Debe registrar las siguientes 4 variables de entorno en el archivo .env
`PLACETOPAY_URL` url a donde apunta la pasarela de pagos, ya sea producción o pruebas, para este caso usamos https://dev.placetopay.com/redirection/
`PLACETOPAY_LOGIN` login provisto por Placetopay
`PLACETOPAY_TRANKEY` trankey provisto por Placetopay
`PLACETOPAY_URL_RETURN` esta es la url a la que retornará una vez termina el flujo en la pasarela de pago, para este caso
y en un ambiente local puede ser algo como http://localhost/demo-placetopay/public/order/callback/

Estos valores se incluyen en el archivoi .env.example como referencia

También deberá configurar los valores de conexión a la base de datos en el archivo .env

