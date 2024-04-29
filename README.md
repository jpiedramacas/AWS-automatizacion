Claro, aquí tienes los requisitos necesarios para desplegar la aplicación en AWS:

1. **Configurar una instancia EC2 en AWS**:
   - Inicia sesión en la consola de AWS y navega a EC2.
   - Haz clic en "Launch Instance" para lanzar una nueva instancia.
   - Selecciona una AMI de Amazon Linux.
   - Selecciona el tipo de instancia t2.small.
   - Asegúrate de configurar adecuadamente los ajustes de seguridad, permitiendo el tráfico HTTP, SSH, además de los puertos 3036 y 8080.
   - Crea una nueva clave de par de claves o utiliza una existente para acceder a tu instancia mediante SSH.
   - Lanza la instancia.

2. **Conectar a la instancia EC2 mediante SSH**:
   - Utiliza tu cliente SSH para conectarte a tu instancia EC2 utilizando la dirección IP pública proporcionada por AWS y la clave de par de claves.

3. **Instalar y configurar el servidor web Apache**:
   - Una vez conectado a la instancia EC2, ejecuta los siguientes comandos:
     ```bash
     sudo yum update -y
     sudo yum install -y docker
     sudo service docker start
     sudo usermod -a -G docker $(whoami)
     sudo yum install -y python3-pip
     sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
     sudo chmod +x /usr/local/bin/docker-compose
     docker-compose --version
     ```

4. **Crear una Lambda**:
   - Crea una lambda con Python 3.12 y elige el único IAM TOL disponible.
   - Añade el código proporcionado en la lambda.

5. **Crear un topico SNS**:
   - Crea un topico SNS y suscríbelo a la lambda.

6. **Configuración**:
   - Crea los archivos necesarios para tu aplicación PHP.
   - Crea el archivo `docker-compose.yml` para definir los servicios Docker.
   - Crea el script SQL `create_table.sql` para la base de datos.

7. **Automatización de Operaciones**:
   - Crea el script `monitoring_services_status.sh` para monitorear los contenedores Docker.
   - Dale permisos de ejecución al script y añádelo al cron para ejecutarse cada minuto.

8. **Alarmas**:
   - Crea alarmas en CloudWatch para las métricas definidas y conéctalas a SNS.

¡Con estos pasos, tu aplicación estará lista y funcionando en AWS!
