<?php
  declare(strict_types=1);

  namespace Fawno\AEAT\Tests;

	use Fawno\AEAT\Contribuyente\Contribuyente;
	use PHPUnit\Framework\TestCase;

  class ContribuyenteTest extends TestCase {
		public function testContribuyente () {
			$contribuyente = Contribuyente::create('99999972C', 'Fulanito de Tal');

			$this->assertInstanceOf(Contribuyente::class, $contribuyente);
			$this->assertEquals('99999972C', $contribuyente->Nif);
			$this->assertEquals('Fulanito de Tal', $contribuyente->Nombre);
			$this->assertEquals('', $contribuyente->Resultado);
		}

		public function testtoArray () {
			$contribuyente = Contribuyente::create('99999972C', 'Fulanito de Tal');

			$this->assertEquals([
				'Nif' => '99999972C',
				'Nombre' => 'Fulanito de Tal',
				'Resultado' => '',
			], $contribuyente->toArray());
		}

		public function testtoShortArray () {
			$contribuyente = Contribuyente::create('99999972C', 'Fulanito de Tal');

			$this->assertEquals([
				'Nif' => '99999972C',
				'Nombre' => 'Fulanito de Tal',
			], $contribuyente->toShortArray());
		}

		public function testtoRequest () {
			$contribuyente = Contribuyente::create('99999972C', 'Fulanito de Tal');

			$this->assertEquals([
				'Contribuyente' => [
					'Nif' => '99999972C',
					'Nombre' => 'Fulanito de Tal',
				]
			], $contribuyente->toRequest());
		}
  }
