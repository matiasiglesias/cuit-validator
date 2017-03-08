<?php
/*
 * This file is part of the Diff package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuitValidator\Validator;

use PHPUnit_Framework_TestCase;
use CuitValidator\Validator\Cuit;

class CuitTest extends PHPUnit_Framework_TestCase
{
    /** @var  Cuit */
    protected $validador;

    public function setUp()
    {
        $this->validador = new Cuit();
    }

    public function testCuitNoNumerico()
    {
        $this->assertFalse($this->validador->isValid("A"));
    }

    public function testCuitNull()
    {
        $this->assertFalse($this->validador->isValid(null));
    }

    public function testFiltradoCuit()
    {
        $this->validador->setFiltrarCuitNoNumerico(true);
        $this->assertTrue($this->validador->isValid("20938693537"));
        $this->assertTrue($this->validador->isValid("20-93869353-7"));
        $this->validador->setFiltrarCuitNoNumerico(false);
        $this->assertFalse($this->validador->isValid("20-93869353-7"));
    }

    public function testCuitPersonaFisicaValido()
    {
        $this->validador->setIncluirPersonas(true);
        $this->assertTrue($this->validador->isValid("20-93869353-7"));
    }

    public function testCuitPersonaFisicaInvalido()
    {
        $this->validador->setIncluirPersonas(true);
        $this->assertFalse($this->validador->isValid("20-93869353-8"));
    }

    public function testCuitPersonaJuridicaValido()
    {
        $this->validador->setIncluirEmpresas(true);
        $this->assertTrue($this->validador->isValid("30-63823293-2"));
    }

    public function testCuitPersonaJuridicaInvalido()
    {
        $this->validador->setIncluirEmpresas(true);
        $this->assertFalse($this->validador->isValid("30638232933"));
    }

    public function testCuitPersonaJuridicaValidoSinIncluirEmpresas()
    {
        $this->validador->setIncluirEmpresas(false);
        $this->assertFalse($this->validador->isValid("30638232932"));
    }

    public function testCuitPersonaFisicaValidoSinIncluirPersonas()
    {
        $this->validador->setIncluirPersonas(false);
        $this->assertFalse($this->validador->isValid("20938693537"));
    }
}
