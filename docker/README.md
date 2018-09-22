Soporte Osticket
===============

# Introducción

Con los archivos en este repositorio se posee lo necesario para correr Osticket.
A continuación se detallaran los pasos a seguir para trabajar de forma local y correr el sistema en producción.


## Ambiente local

Para trabajar de forma local se utiliza el archivo llamado: docker-compose.desarrollo.yml

```bash
docker-compose -f docker-compose.desarrollo.yml up|ps|down|logs
```

Utilizando este docker-compose.dearrollo.yml se tendrá configurado un ambiente local de desarrollo para poder trabajar sobre OsTicket.


### Iniciar aplicación

1. Construir imagen que utilizará la aplicación:
```
docker-compose -f docker-compose.desarrollo.yml build
```
2. Iniciar contenedores
```
docker-compose -f docker-compose.desarrollo.yml up -d
```
3. Ver estado y logs de servicios
```
docker-compose -f docker-compose.desarrollo.yml ps
```
```
docker-compose -f docker-compose.desarrollo.yml logs -f
```


Los cambios que se realicen en el código de la aplicación, se reflejarán de forma inmediata en la aplicación. Es posible acceder a la aplicación ingresando a través del navegador vía http://localhost.
Por defecto la aplicación levanta en el puerto 80, este puede ser modificado en el archivo *docker-compose.desarrollo.yml*.




*Notas: la aplicación genera e instala los archivos de configuración y la base de datos de la aplicación la primera vez que inicia. 
Para que funcione correctamente de forma local, los archivos de configuración y paquetes de lenguaje se almacenan en un volumen, caso contrario se perderán ya que los directorios donde se encuentran se sobreescribe al montar el directorio con el codigo de la aplicación.*


## Ambiente productivo

Para el entorno productivo se utilizará el archivo llamado: docker-compose.yml.

```bash
docker-compose -f docker-compose.produccion.yml up|ps|down|logs
```

Este docker-compose.yml para produccion realizara el build de la imagen descargando los archivos desde el siguiente link: https://bitbucket.org/testa-team/soporte/get/develop.tar.gz.

Para realizar este build se utiliza otro Dockerfile llamado Dockerfile-prod. En este Dockerfile-prod, para poder descargar los archivos, se deben configurar los accesos de Bitbucket, de lo contrario el build de la imagen fallara.

Para la configuracion de los accesos simplemente se deben editar dos variables de ambientes en el Dockerfile-prod:
```bash
ENV USER usuario-bitbucket
ENV PASS password-usuario-bitbucket
```


Iniciando los servicios configurados en este docker-compose la aplicación se levantará en el puerto 80 del servidor.
En las siguientes secciones se explicará detalladamente el significado de cada una de las variables de ambientes utilizadas para configurar la aplicación y los volúmenes que se utilizan.



# Inicio

## Configuración de acceso a MySQL

`SOPORTE_DATABASE_PREFIX`

El prefijo que se utilizara en la instalación de la base de datos. Por defecto 'soporte_'

`SOPORTE_DATABASE_HOST`

El nombre de host o IP del servidor MySQL que se utilizara.

`SOPORTE_DATABASE_NAME`

Nombre de base de datos a utilizar, por defecto *soporte*.

`SOPORTE_DATABASE_USER`

El nombre de usuario que se utilizará para conectarse al servidor MySQL. Por defecto 'soporte'.

`SOPORTE_DATABASE_PASSWORD`

La contraseña que utilizará el usuario definido en `SOPORTE_DATABASE_USER` para conectarse al servidor MySQL.


# Configuración de mail

Esta imagen admite el envío de correos enviando estos directamente a un servidor SMTP designado.
Por lo tanto, para que esto funcione, se debe proporcionar la configuración SMTP relevante a través de las siguientes variables de ambiente.

Para recopilar automáticamente el correo electrónico de una cuenta externa(POP3/IMAP), configure los ajustes de la cuenta de correo desde el panel de administración.


## Configuración SMTP


`SOPORTE_SMTP_HOST`

El nombre de host (o dirección IP) del servidor SMTP para enviar todo el correo saliente. El valor predeterminado es *localhost*.

`SOPORTE_SMTP_PORT`

El puerto TCP para conectarse en el servidor. Por defecto *25*. Usualmente puede ser 25, 265 o 587.

`SOPORTE_SMTP_FROM`

La direccion que se utilizara al enviar un correo(no es lo mismo que el encabezado From:).

`SOPORTE_SMTP_TLS`

Se debe indicar 'on' o 'off' para indicar si debe ser utilizado TLS para crear una conexión segura al servidor. Por defecto 'on'.

`SOPORTE_SMTP_TLS_CERTS`

Sí `SOPORTE_SMTP_TLS` se encuentra en *on*, indica el archivo que contiene los certificados root utilizados para verificar el certificado del servidor. Por defecto contiene los certificados instalados en el sistema. Esto se debería cambiar si usa su propia autoridad  de certificación o si se conectan a un servidor con un certificado autofirmado.

`SOPORTE_SMTP_USER`

La identidad del usuario a utilizar para la autenticación SMTP. Si se especificar un valor, se habilitará la autenticación SMTP.

`SOPORTE_SMTP_PASSWORD`

La contraseña asociada con el usuario utilizada para la autenticación SMTP.


## Configuración IMAP/POP3

`CRON_INTERVAL`

Específica cada cuantos minutos el sistema ejecutará un cron para verificar si hay correos entrantes. Por defecto 5 minutos.
Si se ingresa 0, se deshabilita la ejecución del script. Tener en cuenta que este funciona en conjunto con el intervalo de comprobación de correos
especificado en el panel de control de admin, se debe especificar en ambos el valor que se desea.


# Volúmenes

Esta imagen soporta dos volúmenes.
This image currently supports three volumes. None of these need to used if you do not require them.

`/data/upload/include/plugins`

Esta directorio es donde se almacenan los plugins de OSTicket. Como los plugins no se encuentran en la imagen, deben almacenarse en un volumen fuera de la imagen de Docker.

`/data/upload/include/i18n`

En este volumen se almacenarán los paquetes de idiomas, los cuales pueden ser descargados. Ya varios están incluidos en esta imagen.


# Variables de ambiente

`INSTALL_SECRET`

Cadena de string secreta para la instalación de OSTicket. Un valor Random es generado al inicio y se almacena dentro del contenedor si este no se proporciona.
Si se usa en producción, se debe especificar para que la recreación del contenedor no cause la pérdida de este string secreto.

PROBAR ESTE

`INSTALL_CONFIG`

Si necesita un archivo de configuración para OSTicket con contenido personalizado, debe crear uno y montarlo en su
contenedor como un volumen. 

`SOPORTE_EMAIL`

Cuenta de correo electrónico de mesa de ayuda. Este se coloca en el archivo de configuración y en la base de datos durante la  instalación. Valor por defecto 'helpdesk@example.com'

## Instalación de la base de datos

Las siguientes variables de ambientes pueden ser utilizadas para proporcionar valores predeterminados durante la instalación de la base de datos automatizada, si se desean cambiar estas configuraciones se puede hacer desde el panel de administración. Estas solo se usan al crear la base de datos inicial.

`SOPORTE_NAME`

El nombre utilizado para el sistema de mesa de ayuda. Por defecto "My Helpdesk".

`SOPORTE_ADMIN_FIRSTNAME`

Nombre del usuario administrador que se creará automáticamente. Por defecto 'Admin'.

`SOPORTE_ADMIN_LASTNAME`

Apellido del usuario administrador que se creará automáticamente. Por defecto 'User'.

`SOPORTE_ADMIN_EMAIL`

Direccion de mail del usuario administrador que se creará automáticamente. Por defecto 'admin@example.com'.

`SOPORTE_ADMIN_USERNAME`

Nombre de usuario del usuario administrador que se creará automáticamente. Por defecto 'ostadmin'.

`SOPORTE_ADMIN_PASSWORD`

Contraseña de usuario del usuario administrador que se creará automáticamente. Por defecto 'Admin1'.

