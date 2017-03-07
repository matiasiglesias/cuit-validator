Módulo Validador de CUIT para ZF2
=================================
Clave Única de Identificación Tributaria
utilizado por la AFIP en Argentina
Más información en [WikiPedia](http://es.wikipedia.org/wiki/Clave_Única_de_Identificación_Tributaria)

##Instalacion

Instala el modulo con composer agregando el siguiente require "require" en el archivo `composer.json`

```json
{
	"require": {
		"matiasiglesias/zf2-cuit-validator": "1.*"
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
                    ),
                ),
            )
        )));

    ?>
```

## Configuracion
Estas son las opciones del validador:

* *incluirEmpresas* Boolean. Permite CUIT de empresas (prefijos 30 y 33). Valor por defecto *false*.
* *incluirPersonas* Boolean. permite CUIT de personas (prefijos 20, 23, 24 y 27). Valor por defecto *true*.


## Contacto
1. Via email [matiasiglesias@matiasiglesias.com.ar](mailto:matiasiglesias@matiasiglesias.com.ar).
2. Via Twitter[@matiashiglesias](https://twitter.com/matiashiglesias)

## Licencia

CuitValidator is licensed under the MIT license.  
See the included LICENSE file.
Copyright (c) 2013-2017 Matias Iglesias

http://www.matiasiglesias.com.ar/  
All rights reserved.