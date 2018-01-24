# wsdlVNif

Clase para el [Web Service de Calidad de Datos Identificativos](http://www.agenciatributaria.es/AEAT.internet/Inicio/Ayuda/Manuales__Folletos_y_Videos/Manuales_tecnicos/Web_service/Modelos_030__036__037/Informacion_sobre_Web_Services_de_Calidad_de_Datos_Identificativos/Informacion_sobre_Web_Services_de_Calidad_de_Datos_Identificativos.shtml) de la [AEAT](http://www.agenciatributaria.es/)

# Requisitos

AEAT requiere PHP version 5.6 o superior con las extensiones openssl y soap habilitadas.

## Instalación

### Instalar con [`composer.phar`](http://getcomposer.org).

Añade `fawno/aeat` como requisito a tu proyecto:

```sh
php composer.phar require "fawno/aeat"
```

Carga la clase en tu script:

```php
<?php
  require 'vendor/autoload.php';

  use Fawno\AEAT\wsdlVNif;
```

### Instalación manual

Descarga [wsdlVNif.php](https://github.com/fawno/AEAT/raw/master/src/wsdlVNif.php) y guardalo en una ruta accesible.

Carga `wsdlVNif.php` en tu script:

```php
<?php
  require 'wsdlVNif.php';

  use Fawno\AEAT\wsdlVNif;
```

### Instalación manual en CakePHP 2.x

Descarga [wsdlVNif.php](https://github.com/fawno/AEAT/raw/master/src/wsdlVNif.php) y guardalo como Vendor/Fawno/AEAT/wsdlVNif.php

Carga `wsdlVNif.php` en el controlador:

```php
<?php
  App::uses('AppController', 'Controller');
  App::uses('Fawno\AEAT\wsdlVNif', 'Vendor');

  use Fawno\AEAT\wsdlVNif;

  class ExampleController extends AppController {
    public function example () {
      $local_cert = 'certificado.pem';
      $passphrase = 'contraseña';

      $ssl_verifypeer = false;
      $options['trace'] = true;
      $options['cache_wsdl'] = WSDL_CACHE_NONE;

      $wsdlVNif = new wsdlVNif($local_cert, $passphrase, $options, $ssl_verifypeer);
    }
  }
```

# Generar el certificado

El servicio require de un certificado de persona física admitido en la Sede Electrónica de la AEAT, como certificados de empleados públicos o de la FNMT.
También se admiten certificados de representantes de una empresa, no importando el cargo que ocupe la persona dentro de la empresa.

El cliente SOAP de PHP admite la autentificación mediante certificado, pero necesita que el certificado esté en formato PEM.

Para convertir un certificado P12 o PFX a formato PEM se puede utilizar el siguiente código:

```php
<?php
  $pkcs12_file = 'certificado.pfx';
  $pkcs12_pass = 'contraseña';
  $local_cert = 'certificado.pem';

  openssl_pkcs12_read(file_get_contents($pkcs12_file), $certs, $pkcs12_pass);
  openssl_pkey_export($certs['pkey'], $pkey, $passphrase);
  file_put_contents($local_cert, $certs['cert'] . $pkey);
```

Con el código anterior se convierte el certificado en formato P12 `certificado.pfx` al formato PEM (`certificado.pem`). El nuevo certificado está protegido con la misma contraseña del certificado P12 original.

# Ejemplo:

Ejemplo de consulta de un único Nif y de varios Nifs simultáneamente:

```php
<?php
  require 'vendor/autoload.php';

  use Fawno\AEAT\wsdlVNif;

  $local_cert = 'certificado.pem';
  $passphrase = 'contraseña';

  $ssl_verifypeer = false;
  $options['trace'] = true;
  $options['cache_wsdl'] = WSDL_CACHE_NONE;

  // Para consultar una persona física hay que especificar nombre y apellidos
  $contribuyentes[] = ['Nif' => '00000000T', 'Nombre' => 'Apellido Apellido Nombre'];
  $contribuyentes[] = ['Nif' => '00000000T', 'Nombre' => 'Nombre Apellido Apellido'];
  // Para consultar una empresa basta con poner el Nif y dejar el Nombre vacío.
  $contribuyentes[] = ['Nif' => '00000000T', 'Nombre' => null];

  try {
    $wsdlVNif = new wsdlVNif($local_cert, $passphrase, $options, $ssl_verifypeer);

    // Se puede consultar un único Nif
    $result = $wsdlVNif->VNifV2(['Nif' => '00000000T', 'Nombre' => null]);
    print_r($result);

    // También se puede sonsultar múltiples Nifs simultáneamente (hasta 10k)
    $result = $wsdlVNif->VNifV2($contribuyentes);
    print_r($result);
  } catch (SoapFault $fault) {
    print_r($fault);
  }
```
