[![GitHub license](https://img.shields.io/github/license/fawno/AEAT.svg)](https://github.com/fawno/AEAT/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/fawno/AEAT.svg)](https://github.com/fawno/AEAT/releases)
[![Packagist](https://img.shields.io/packagist/v/fawno/AEAT.svg)](https://packagist.org/packages/fawno/aeat)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fawno/AEAT)](https://packagist.org/packages/fawno/aeat/stats)
[![Documentation](https://img.shields.io/badge/manual-wsdlVNif-blue.svg)](docs/wsdlVNif.md)

# AEAT
Clases para los servicios web de la [AEAT](http://www.agenciatributaria.es/)

## wsdlVNif
Clase para el [Web Service de Calidad de Datos Identificativos](http://www.agenciatributaria.es/AEAT.internet/Inicio/Ayuda/Manuales__Folletos_y_Videos/Manuales_tecnicos/Web_service/Modelos_030__036__037/Informacion_sobre_Web_Services_de_Calidad_de_Datos_Identificativos/Informacion_sobre_Web_Services_de_Calidad_de_Datos_Identificativos.shtml) de la [AEAT](http://www.agenciatributaria.es/)

[Documentación wsdlVNif](docs/wsdlVNif.md)

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
