# Git Deploy Hook for Bitbucket - v0.1 #

Git Deploy Hook for Bitbucket es una aplicación de integración continua para los repositorios de prueba que ayuda a los desarrolladores para obtener actualizaciones instantaneas en la liga de prueba al actualizar un branch en particular.

--------------

$ mkdir /var/www/.ssh/

$ chown www-data:www-data /var/www/.ssh/

$ sudo -u www-data ssh-keygen -t rsa

Luego agregar la llave .pub a algún usuario con acceso a los repos y verificar el certificado con bitbucket.

$ sudo -u www-data ssh -vT git@github.com

--------------

Version: 0.1

### ¿Cómo agregar un repositorio? ###

#### Servidor ####

1.- Identificar la ruta del proyecto, ej:

/var/www/proyectos/miproyecto1/

2.- Asegurarse que existe el repositorio GIT o crea uno.

$ git init

3.- Crear el remoto desde nuestro repositorio de Bitbucket con el nombre de "hook_origin" y usando un usuario con permisos suficiente de Bitbucket. Ej:

SSH
$ git remote add hook_origin git@bitbucket.org:PROPIETARIO/PROYECTO.git

HTTPS ( obsoleto )
$ git remote add hook_origin https://USUARIO:CONTRASEÑA@bitbucket.org/PROPIETARIO/PROYECTO.git

4.- Asignar los permisos necesarios a la carpeta del proyecto.

$ chown -R www-data:www-data miproyecto1

5.- Agregar el proyecto a la lista de proyectos aceptados en el archivo XML:

$ nano /var/www/proyectos/git-deploy-hook/repos.xml

Usando el formato pertimente, ej.:

<repository owner="PROPIETARIO" slug="miproyecto1">
	<name>Mi proyecto 1</name>
	<path>/var/www/proyectos/miproyecto1/</path>
</repository>

#### Bitbucket ####

1.- Crear el hook en:

https://bitbucket.org/PROYECTOS/PROYECTO/admin/hooks

Del tipo POST con la url hacia tu instalación de Git Deploy Hook:

http://website.com/git-deploy-hook/index.php

#### GIT local o Sourcetree ####

1.- Crear el branch local llamado "development" y subirlo.
