<?php
/*
  Copyright 2026, Fawno (https://github.com/fawno)

  Licensed under The MIT License
  Redistributions of files must retain the above copyright notice.

  @copyright Copyright 2026, Fawno (https://github.com/fawno)
  @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/
	declare(strict_types=1);

  namespace Fawno\AEAT\Contribuyente;

	use stdClass;

	readonly class Contribuyente {
		private function __construct (public string $Nif, public string $Nombre, public string $Resultado) {}

		public static function parse (stdClass $contribuyente) : Contribuyente {
			return new static($contribuyente->Nif, $contribuyente->Nombre, $contribuyente->Resultado);
		}

		public static function create (string $Nif, string $Nombre = '', string $Resultado = '') : Contribuyente {
			return new static($Nif, $Nombre, $Resultado);
		}

		public function toArray () : array {
			return (array) $this;
		}

		public function toShortArray () : array {
			return array_intersect_key($this->toArray(), [
				'Nif' => null,
				'Nombre' => null,
			]);
		}

		public function toRequest () : array {
			return ['Contribuyente' => $this->toShortArray()];
		}
	}