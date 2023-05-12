# PlateBlurrer

Este proyecto consta de una clase PHP llamada ImageBlurrer que recibe una imagen en cualquier formato en formato Base64. Envía esta imagen a AWS Rekognition para detectar texto en la imagen, luego verifica si el texto detectado coincide con una expresión regular específica. Si es así, la clase aplica un rectángulo negro sobre la región de texto en la imagen para hacerla ilegible. Finalmente, la imagen modificada se devuelve en formato Base64.

# Requisitos

- PHP 7.1 o superior
- Composer
- AWS SDK for PHP
- Intervention Image
- Cuenta de AWS y acceso a AWS Rekognition

# Instalación

- Clona o descarga este repositorio.
- Navega al directorio del proyecto a través de la línea de comandos.
- Ejecuta composer install para instalar las dependencias del proyecto.

# Uso

La clase ImageBlurrer se puede usar de la siguiente manera:

```
require 'ImageBlurrer.php';

$blurrer = new ImageBlurrer();

// Carga una imagen y codifica en Base64
$imagePath = 'path/to/your/image.jpg';
$base64Image = base64_encode(file_get_contents($imagePath));

// Usa el blurrer para desenfocar el texto en la imagen
$result = $blurrer->blurImage($base64Image);

// $result contiene la imagen desenfocada en formato Base64
```

# Configuración de AWS

Asegúrate de configurar correctamente las credenciales de AWS y seleccionar la región correcta en el constructor de la clase ImageBlurrer. Debes tener permisos para usar el servicio AWS Rekognition.

```
public function __construct()
{
    $this->client = new RekognitionClient([
        'version' => 'latest',
        'region'  => 'us-west-2' // Cambia esto a tu región
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
    public function blurImage(Request $request)
    {
        $blurrer = new ImageBlurrer();

        $base64Image = base64_encode(file_get_contents($request->file('image')));

        $result = $blurrer->blurImage($base64Image);

        // $result contiene la imagen desenfocada en formato Base64
        // Puedes devolver este resultado como respuesta
    }
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

```

# Ejemplos

![ejemplo 1](.screenshot1.png?raw=true "1")
![ejemplo 2](.screenshot1.png?raw=true "2")
![ejemplo 3](.screenshot1.png?raw=true "3")
