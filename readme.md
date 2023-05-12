# ImageBlurrer

Un script PHP para desenfocar texto específico en una imagen utilizando AWS Rekognition y la biblioteca de imágenes de Intervención.

## Requisitos

1. PHP 7.4 o superior
2. [Composer](https://getcomposer.org/)
3. [AWS SDK para PHP](https://aws.amazon.com/sdk-for-php/)
4. [Biblioteca de imágenes de Intervención](http://image.intervention.io/)
5. Credenciales de AWS configuradas en tu máquina o pasadas como argumentos al constructor de `ImageBlurrer`.

## Instalación

1. Clona este repositorio a tu máquina local o descárgalo como un archivo zip y descomprímelo.
2. Navega a la carpeta del proyecto en tu terminal y ejecuta `composer install` para instalar las dependencias.
3. Configura tus credenciales de AWS en tu máquina o pásalas como argumentos al constructor de `ImageBlurrer`.

## Uso

```php
require_once 'ImageBlurrer.php';

// Si tienes las credenciales de AWS configuradas en tu máquina
$blurrer = new ImageBlurrer();

// Si prefieres pasar las credenciales como argumentos
// $blurrer = new ImageBlurrer('your-access-key', 'your-secret-key');

$base64Image = base64_encode(file_get_contents('path/to/your/image.jpg'));
$blurredImage = $blurrer->blurImage($base64Image);

// Hacer algo con la imagen desenfocada...
echo '<img src="' . $blurredImage . '" />';

# Configuración de AWS

Asegúrate de configurar correctamente las credenciales de AWS y seleccionar la región correcta en el constructor de la clase ImageBlurrer. Debes tener permisos para usar el servicio AWS Rekognition.

```

public function \_\_construct()
{
$this->client = new RekognitionClient([
'version' => 'latest',
'region' => 'us-west-2' // Cambia esto a tu región
]);

    $this->imageManager = new ImageManager(['driver' => 'gd']);

}

```

# Notas

La función blurImage() puede lanzar una excepción si se produce un error durante el procesamiento de la imagen. Asegúrate de manejar estas excepciones en tu código.

```

try {
$blurredImage = $blurrer->blurImage($base64Image);
} catch (Exception $e) {
// Manejo de errores
}

```

# Uso en Laravel

Para utilizar la clase ImageBlurrer en un proyecto Laravel, sigue estos pasos:

Copia la clase ImageBlurrer.php en tu directorio de aplicación. Por convención, puedes colocarla en la carpeta app/Services.

Asegúrate de que el espacio de nombres de la clase ImageBlurrer coincida con la estructura de carpetas de tu aplicación Laravel. Por ejemplo, si colocas ImageBlurrer.php en app/Services, entonces tu espacio de nombres debería ser App\Services.

En tu controlador, importa la clase ImageBlurrer y úsala para desenfocar las imágenes. Aquí hay un ejemplo:

```

namespace App\Http\Controllers;

use App\Services\ImageBlurrer;
use Illuminate\Http\Request;

class ImageController extends Controller
{
public function blur(Request $request)
{
$blurrer = new ImageBlurrer();

    $base64Image = base64_encode(file_get_contents($request->file('image')->getRealPath()));
    $blurredImage = $blurrer->blurImage($base64Image);

    return view('blurred_image', ['image' => $blurredImage]);

}

```

# Uso en CakePHP

Para usar la clase ImageBlurrer en un proyecto CakePHP, sigue estos pasos:

Copia la clase ImageBlurrer.php en tu directorio src. Puedes crear un nuevo subdirectorio, como Service, para mantener tu código organizado.

Asegúrate de que el espacio de nombres de la clase ImageBlurrer coincida con la estructura de carpetas de tu aplicación CakePHP. Por ejemplo, si colocas ImageBlurrer.php en src/Service, entonces tu espacio de nombres debería ser App\Service.

En tu controlador, importa la clase ImageBlurrer y úsala para desenfocar las imágenes. Aquí hay un ejemplo:

```

namespace App\Controller;

use App\Service\ImageBlurrer;
use Cake\Http\Exception\InternalErrorException;

class ImagesController extends AppController
{
public function blurImage()
{
$blurrer = new ImageBlurrer();

        // Asegúrate de tener un manejo de archivos adecuado aquí
        $base64Image = base64_encode(file_get_contents($this->request->getData('image')));

        try {
            $result = $blurrer->blurImage($base64Image);
        } catch (\Exception $e) {
            throw new InternalErrorException('Error al procesar la imagen.');
        }

        // $result contiene la imagen desenfocada en formato Base64
        // Puedes devolver este resultado como respuesta
    }

}

## Configuración con AWS Rekognition

El script utiliza AWS Rekognition para detectar texto en las imágenes. Debes tener una cuenta de AWS y debes tener configuradas tus credenciales de AWS en tu máquina.

Las mejores prácticas para configurar AWS Rekognition incluyen:

- Configurar las credenciales de AWS en tu máquina utilizando el AWS CLI.
- Utilizar roles de IAM para gestionar los permisos de tu aplicación.
- Nunca subir tus credenciales de AWS a repositorios públicos.
- Configurar una política de uso de datos para proteger tus imágenes.
- Configurar límites de tarifa para evitar costos inesperados.

# Ejemplos

![ejemplo 1](https://raw.githubusercontent.com/asdrubalp9/imageblurrer/main/screenshot1.png?raw=true "1")
![ejemplo 2](https://raw.githubusercontent.com/asdrubalp9/imageblurrer/main/screenshot2.png?raw=true "2")
![ejemplo 3](https://raw.githubusercontent.com/asdrubalp9/imageblurrer/main/screenshot3.png?raw=true "3")
