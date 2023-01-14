# Practicas-Tecnica-LancerGroup
La finalidad de este repositorio es poder medir los conocimientos del participante mediante una practicas tecnica(Backend) para poder entrar en Lancer Group.

#Pasos para correr el proyecto

1. Clonar el repostorio `git clone  https://github.com/jordanyrosario/Practicas-Tecnica-LancerGroup`
2. Acceder a la carpeta src 
3. Ejecutar el comando `composer install`, si no tienes composer lo puedes encotrar aqui <https://getcomposer.org/>
3. Renombrar el archivo `env` a `.env`
4. Editar el archivo `.env` y aplicar la configuracion de tu base de datos ej:
~~~
database.default.hostname = localhost
database.default.database = my_db //nombre de base de datos
database.default.username = my_db_user // usuario de base de datos
database.default.password = my_password //contrasena de base de datos
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306 // puerto de base de datos
~~~
6. Ejecute una terminar  con php y ejecute los siguites comandos:
 - `php spark migrate`
 - `php spark db:seed CountrySeeder`
 - `php spark serve`
 7. Abra el navegator y dirijase a la direcion <http://localhost:8080/> o la direccion que este muestre en la consola.

## Nota
Hay muchos detalles que decidí  ignorar por razones de tiempo, tales como las notificaciones luego de completar un formulario, algunos mensajes de error en las solicitudes de ajax, contenido extra en la plantilla utilizada, captura de otros posibles errores. 
A excepción de esos detalles los requisitos solicitados debería estar funcionado
