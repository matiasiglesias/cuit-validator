<?php
/**
 * Copyright (c) 2013-2022 Matias Iglesias <matiasiglesias@matiasiglesias.com.ar>.
 *
 *
 * Redistribution and use in source and binary forms are permitted
 * provided that the above copyright notice and this paragraph are
 * duplicated in all such forms and that any documentation, advertising
 * materials, and other materials related to such distribution and use
 * acknowledge that the software was developed by Matias Iglesias. The
 * name of the Matias Iglesias may not be used to endorse or promote
 * products derived from this software without specific prior written
 * permission.
 *
 * THIS SOFTWARE IS PROVIDED "AS IS" AND WITHOUT ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace CuitValidator\Validator;

use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\Validator\AbstractValidator;

class Cuit extends AbstractValidator
{
    const MSG_NUMERIC = 'msgNumeric';
    const MSG_INVALID = 'MsgInvalid';
    const MSG_INVALID_PREFIX = 'MsgInvalidPrefix';
    const MSG_INVALID_LENGTH = 'MsgInvalidLength';

    protected $messageTemplates = [
        self::MSG_NUMERIC => "'%value%' no es numerico",
        self::MSG_INVALID => "'%value%' no es un CUIT valido",
        self::MSG_INVALID_PREFIX => "Prefijo de CUIT invalido",
        self::MSG_INVALID_LENGTH => "El CUIT debe tener 11 digitos",
    ];

    /**
     * Options for the between validator
     *
     * @var array
     */
    protected $options = [
        'incluirEmpresas' => false,
        'incluirPersonas' => true,
        'filtrarCuitNoNumerico' => true,
        'whiteList' => [],
    ];

    /**
     * Sets validator options
     * Accepts the following option keys:
     *   'incluirEmpresas' => boolean, permite CUIT de empresas (prefijos 30 y 33)
     *   'incluirPersonas' => boolean, permite CUIT de personas (prefijos 20, 23, 24 y 27)
     *   'filtrarCuitNoNumerico' => boolean, filtra los caracteres no numéricos, por ejemplo, los guiones "-"
     *   'whiteList' => array, lista de CUITs permitidos, por ejemplo, ['20-12345678-9', '99-99999999-9']
     *
     * @param  array|Traversable $options
     */
    public function __construct(array $options = [])
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }
        if (!is_array($options)) {
            $options = func_get_args();
            $temp['incluirEmpresas'] = array_shift($options);
            if (!empty($options)) {
                $temp['incluirPersonas'] = array_shift($options);
            }

            $options = $temp;
        }

        parent::__construct($options);
    }

    /**
     * Returns the incluirEmpresas option
     *
     * @return bool
     */
    public function getIncluirEmpresas()
    {
        return $this->options['incluirEmpresas'];
    }

    /**
     * Sets the incluirEmpresas option
     *
     * @param  bool $incluirEmpresas
     * @return Cuit Provides a fluent interface
     */
    public function setIncluirEmpresas($incluirEmpresas)
    {
        $this->options['incluirEmpresas'] = $incluirEmpresas;

        return $this;
    }

    /**
     * Returns the incluirPersonas option
     *
     * @return bool
     */
    public function getIncluirPersonas()
    {
        return $this->options['incluirPersonas'];
    }

    /**
     * Sets the incluirPersonas option
     *
     * @param  bool $incluirPersonas
     * @return Cuit Provides a fluent interface
     */
    public function setIncluirPersonas($incluirPersonas)
    {
        $this->options['incluirPersonas'] = $incluirPersonas;

        return $this;
    }

    /**
     * Returns the filtrarCuitNoNumerico option
     *
     * @return bool
     */
    public function getFiltrarCuitNoNumericos()
    {
        return $this->options['filtrarCuitNoNumerico'];
    }

    /**
     * Sets the filtrarCuitNoNumerico option
     *
     * @param  bool $filtrar
     * @return Cuit Provides a fluent interface
     */
    public function setFiltrarCuitNoNumerico($filtrar)
    {
        $this->options['filtrarCuitNoNumerico'] = $filtrar;

        return $this;
    }

    /**
     * Returns the whiteList option
     *
     * @return string[]
     */
    public function getWhiteList()
    {
        return $this->options['whiteList'];
    }

    /**
     * Sets the whiteList option
     *
     * @param  bool $filtrar
     * @return Cuit Provides a fluent interface
     */
    public function setWhiteList($whiteList)
    {
        $this->options['whiteList'] = $whiteList;

        return $this;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);

        if ($this->getFiltrarCuitNoNumericos()) {
            $value = preg_replace("/[^\d]/", "", $value);
        }

        // Me fijo si el cuit está en el whiteList
        if (!empty($this->getWhiteList())) {
            if (in_array($value, $this->getWhiteList())) {

                return true;
            }
        }

        if (!is_numeric($value)) {
            $this->error(self::MSG_NUMERIC);

            return false;
        }

        if (strlen($value) != 11) {
            $this->error(self::MSG_INVALID_LENGTH);

            return false;
        }

        $prefijo = (int) substr($value, 0, 2);

        $prefijos_validos = [];

        if ($this->getIncluirPersonas()) {
            array_push($prefijos_validos, 20, 23, 24, 27);
        }

        if ($this->getIncluirEmpresas()) {
            array_push($prefijos_validos, 30, 33);
        }

        if (!in_array($prefijo, $prefijos_validos)) {
            $this->error(self::MSG_INVALID_PREFIX);

            return false;
        }

        $coeficiente = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum = $sum + ($value[$i] * $coeficiente[$i]);
        }

        $resto = 11 - ($sum % 11);

        if ($resto == 11) {
            $resto = 0;
        } elseif ($resto == 10) {
            $resto = 9;
        }

        if ($value[10] != $resto) {
            $this->error(self::MSG_INVALID);

            return false;
        }

        return true;
    }
}
