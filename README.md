# Sistema de Consultas por QR

## Descripción

El **Sistema de Consultas por QR** permite a los usuarios acceder a información específica mediante la lectura de códigos QR. Este sistema está diseñado para optimizar el acceso a datos almacenados en una base de datos, proporcionando una solución rápida y eficiente para la consulta de información en tiempo real.

El sistema web fue implementado para la **validación de permisos por QR**, utilizando el plugin **PHPQR Code** para la generación de códigos QR y **FPDF** para la generación de reportes en PDF. Se utilizó **Composer** para instalar las librerías necesarias de **PHPQR Code**.

## Tecnologías Utilizadas

- **PHP y MySQL**: Backend y gestión de base de datos.
- **HTML, CSS y JavaScript**: Desarrollo de la interfaz web.
- **Bootstrap**: Diseño responsivo.
- **PHPQR Code**: Generación de códigos QR.
- **FPDF**: Generación de reportes en PDF.
- **Composer**: Gestión de dependencias PHP.
- **Servidor Apache**: Para ejecutar la aplicación en un entorno local o en la web.

## Características

- Generación de códigos QR para cada registro en la base de datos.

- Consulta de información en tiempo real mediante escaneo de QR.

- Interfaz web intuitiva y adaptable.

- Gestión de registros con opciones de agregar, modificar y eliminar.

- Validación de permisos por QR.

- Exportación de permiso en PDF

## Instalación y Configuración

### Requisitos

- Servidor con **Apache, PHP y MySQL** (XAMPP, LAMP o similar).
- Composer instalado para la gestión de dependencias.

### Pasos de instalación

1. Clonar el repositorio:
   ```bash
   https://github.com/Cfplaza998/Sistema_web_de_consultas_QR.git
   ```
2. Configurar la base de datos en MySQL:
   - Crear una base de datos llamada `sistema_qr`.
   - Importar el archivo `database.sql` incluido en el repositorio.
3. Instalar las dependencias con Composer:
   ```bash
   composer install
   ```
4. Configurar el servidor web:
   - Copiar los archivos del proyecto en la carpeta `htdocs` de XAMPP.
   - Modificar `config.php` con las credenciales de la base de datos.
5. Acceder al sistema mediante el navegador:
   ```
   http://localhost/Sistema_de_consultas_por_qr
   ```

## Uso del Sistema

1. Generar un código QR para un nuevo registro.
2. Escanear el QR con la cámara del dispositivo o una aplicación de escaneo.
3. Visualizar la información relacionada al código escaneado.
4. Validar permisos mediante el código QR.
5. Gestionar registros desde la interfaz de administración.
6. Descargar reportes en PDF o Excel según las necesidades.

## Contribuciones

Las contribuciones son bienvenidas. Para contribuir:

1. Hacer un fork del repositorio.
2. Crear una nueva rama (`git checkout -b feature-nueva-caracteristica`).
3. Hacer commit de los cambios (`git commit -m 'Agregada nueva característica'`).
4. Hacer push a la rama (`git push origin feature-nueva-caracteristica`).
5. Abrir un pull request.

## Licencia

Este proyecto está licenciado bajo la **MIT License**.

## Contacto

- **Autor**: Fernando Plaza Calle
- **Email**: plaza3419\@gmail.com
- **GitHub**: Cfplaza998

---

¡Espero que este README te ayude a documentar tu proyecto en GitHub! 🚀

