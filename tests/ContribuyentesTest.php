<?php
  declare(strict_types=1);

  namespace Fawno\AEAT\Tests;

	use Fawno\AEAT\Contribuyente\Contribuyente;
	use Fawno\AEAT\Contribuyente\Contribuyentes;
	use PHPUnit\Framework\TestCase;

  class ContribuyentesTest extends TestCase {
		public function testContribuyente () {
			$contribuyentes = Contribuyentes::create(
				Contribuyente::create('99999972C', 'Fulanito de Tal'),
				Contribuyente::create('99999999R', 'Futanito de Cual'),
			);

			$this->assertInstanceOf(Contribuyentes::class, $contribuyentes);
		}

		public function testtoArray () {
			$contribuyentes = Contribuyentes::create(
				Contribuyente::create('99999972C', 'Fulanito de Tal'),
				Contribuyente::create('99999999R', 'Futanito de Cual'),
			);

			$this->assertEquals([
				Contribuyente::create('99999972C', 'Fulanito de Tal'),
				Contribuyente::create('99999999R', 'Futanito de Cual'),
			], $contribuyentes->getArrayCopy());
		}

		public function testtoRequest () {
			$contribuyentes = Contribuyentes::create(
				Contribuyente::create('99999972C', 'Fulanito de Tal'),
				Contribuyente::create('99999999R', 'Futanito de Cual'),
			);

			$this->assertEquals([
				'Contribuyente' => [
					[
						'Nif' => '99999972C',
						'Nombre' => 'Fulanito de Tal',
					],
					[
						'Nif' => '99999999R',
						'Nombre' => 'Futanito de Cual',
					],
				]
			], $contribuyentes->toRequest());
		}
  }
