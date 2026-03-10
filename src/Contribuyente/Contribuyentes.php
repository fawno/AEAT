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

  use ArrayObject;
	use stdClass;
	use Fawno\AEAT\Contribuyente\Contribuyente;

  class Contribuyentes extends ArrayObject {
		public static function parse (stdClass|array $contribuyentes) : Contribuyente|Contribuyentes {
			if (is_object($contribuyentes)) {
				return Contribuyente::parse($contribuyentes);
			}

			$_entities = [];

      foreach ($contribuyentes as $contribuyente) {
       	$_entities[] = ($contribuyente instanceof Contribuyente) ? $contribuyente : Contribuyente::parse($contribuyente);
      }

			return new self($_entities);
		}

		public static function create (Contribuyente ...$contribuyentes)  : Contribuyentes {
			return new self($contribuyentes);
		}

		public function toRequest () : array {
			return [
				'Contribuyente' => array_map(
					function(Contribuyente $contribuyente) { return $contribuyente->toShortArray(); },
					$this->getArrayCopy()
				),
			];
		}
  }
