Módulo Validador de CUIT para ZF2
=================================

[![Build Status](https://travis-ci.org/matiasiglesias/cuit-validator.svg?branch=master)](https://travis-ci.org/matiasiglesias/cuit-validator)
[![Latest Stable Version](https://poser.pugx.org/matiasiglesias/cuit-validator/version)](https://packagist.org/packages/matiasiglesias/cuit-validator)
[![Latest Unstable Version](https://poser.pugx.org/matiasiglesias/cuit-validator/v/unstable)](//packagist.org/packages/matiasiglesias/cuit-validator)
[![Total Downloads](https://poser.pugx.org/matiasiglesias/cuit-validator/downloads)](https://packagist.org/packages/matiasiglesias/cuit-validator)
[![License](https://poser.pugx.org/matiasiglesias/cuit-validator/license)](https://packagist.org/packages/matiasiglesias/cuit-validator)
[![composer.lock available](https://poser.pugx.org/matiasiglesias/cuit-validator/composerlock)](https://packagist.org/packages/matiasiglesias/cuit-validator)
[![Dependency Status](https://www.versioneye.com/user/projects/58c414dc62d602004575bc5f/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58c414dc62d602004575bc5f)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/06c006c0-1b9d-420f-8a04-af95aa0df9eb/mini.png)](https://insight.sensiolabs.com/projects/06c006c0-1b9d-420f-8a04-af95aa0df9eb)


#Introducción

Módulo validador de Clave Única de Identificación Tributaria
utilizado por la AFIP en Argentina
Más información en [Wikipedia](http://es.wikipedia.org/wiki/Clave_Única_de_Identificación_Tributaria)

##Instalacion

Instala el módulo con composer agregando el siguiente require "require" en el archivo `composer.json`

```json
{
	"require": {
		"matiasiglesias/cuit-validator": "1.*"
	}
}
```

luego, ejecuta

```bash
$ php composer.phar update
```

y habilita el módulo en `application.config.php`

```php
array(
	'modules' => array(
		'Application',
		'CuitValidator',
		// ...
	),
);
```



## Uso
Agrega el validador

```php
    <?php

        $inputFilter->add($factory->createInput(array(
            'name'     => 'cuit',
            'required' => true,
            'filters'  => array(
                array('name' => 'Digits'), //Filtra los guiones
            ),
            'validators' => array(
                array(
                    'name' => 'CuitValidator\Validator\Cuit',
                    'options' => array(
                        'incluirEmpresas' => true, //Permite CUIT de Empresas o Personas Juridicas
                        'incluirPersonas' => true, //Permite CUIT de Personas Fisicas
                        'filtrarCuitNoNumerico' => true, //Filtra cualquier caracter no numérico del CUIT (ej. '-')
                    ),
                ),
            )
        )));

    ?>
```

## Configuración
Estas son las opciones del validador:

* **incluirEmpresas** Boolean. Permite CUIT de empresas (prefijos 30 y 33). Valor por defecto *false*.
* **incluirPersonas** Boolean. Permite CUIT de personas (prefijos 20, 23, 24 y 27). Valor por defecto *true*.
* **filtrarCuitNoNumerico** Boolean. Filtra cualquier caracter no numérico del CUIT (ej. '-'). Valor por defecto *true*.


## Contacto
1. Via email [matiasiglesias@matiasiglesias.com.ar](mailto:matiasiglesias@matiasiglesias.com.ar).
2. Via Twitter[@matiashiglesias](https://twitter.com/matiashiglesias)

## Licencia

CuitValidator is licensed under the MIT license.  
See the included LICENSE file.
Copyright (c) 2013-2017 Matias Iglesias

http://www.matiasiglesias.com.ar/  
All rights reserved.
