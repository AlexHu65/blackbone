## Descripcion general

INSTRUCCIONES
El reto consiste en utilizar el framework Laravel para replicar la funcionalidad de este API
(Utilities - Zip code) utilizando esta fuente de información. El tiempo de respuesta promedio
deberá ser menor a 300 ms, pero entre menor sea, mejor.
La forma de ejecutar es:
[GET] https://console.boolean.mx/api/zip-codes/{zip_code}
NOTA: Es importante recalcar que si no tiene la sintaxis anterior, no se contará como correcta
y por tanto no se podrá evaluar.
Se deberá publicar el API para que pueda ser probado. En caso de que funcione con las
instrucciones presentadas a continuación, se procederá a revisar el código, el cual deberá ser
compartido a través de un repositorio público en cualquier plataforma de git. El challenge se
evalúa automáticamente.
En caso de que apruebes el challenge, te llegará un correo por parte de nuestro equipo de
reclutamiento para indicar los pasos a seguir.

## Base de datos
Para generar la base de datos, fueron creadas las migraciones correspondientes
![alt text](https://github.com/AlexHu65/blackbone/blob/main/capturas/4.png)

Se agrego un archivo .sql en la ruta principal del proyecto, en la cual ya fueron corridos los comandos
![alt text](https://github.com/AlexHu65/blackbone/blob/main/capturas/3.png)

## Comandos

![alt text](https://github.com/AlexHu65/blackbone/blob/main/capturas/1.png)

![alt text](https://github.com/AlexHu65/blackbone/blob/main/capturas/2.png)

Dentro de la carpeta public de la aplicacion se agrego un xml con los datos necesesarios para hacer la ejecucion de los comandos que se agregaron a la aplicacion.

Comandos
1. php artisan command:zipcodes1
2. php artisan command:zipcodes2
3. php artisan command:zipcodes3

## Ruta de pruebas
![alt text](https://github.com/AlexHu65/blackbone/blob/main/capturas/5.png)

Para hacer el deploy del sistema, se utilizo una instancia gratuita de amazon ec2
http://ec2-54-146-143-160.compute-1.amazonaws.com/api/zip-codes/{zip_code}

Ejemplo:
http://ec2-54-146-143-160.compute-1.amazonaws.com/api/zip-codes/37204