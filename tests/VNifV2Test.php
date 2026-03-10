<?php
  declare(strict_types=1);

  namespace Fawno\AEAT\Tests;

	use Fawno\AEAT\Contribuyente\Contribuyente;
	use Fawno\AEAT\Contribuyente\Contribuyentes;
	use PHPUnit\Framework\TestCase;
  use Fawno\AEAT\wsdlVNif;

  class VNifV2Test extends TestCase {
    /**
     * Kit de certificados de pruebas de FNMT-RCM
     *
     * https://desarrollo.juntadeandalucia.es/node/3172
     */
    public const PKCS_FILE_1 = __DIR__ . '/PKCS/ACTIVO_EIDAS_CERTIFICADO_PRUEBAS___99999972C.pem';
    public const PKCS_PASS_1 = '1234';
    public const PKCS_FILE_2 = __DIR__ . '/PKCS/ACTIVO_EIDAS_CERTIFICADO_PRUEBAS___99999999R.pem';
    public const PKCS_PASS_2 = '1234';

		public function testwsdlVNif () {
			if (!is_file(self::PKCS_FILE_1)) {
				$this->markTestSkipped();
			}

			$wsdlVNif = new wsdlVNif(self::PKCS_FILE_1, self::PKCS_PASS_1, [], false);
			$this->assertInstanceOf(wsdlVNif::class, $wsdlVNif);

			$contribuyente = Contribuyente::create('99999972C', '', 'NO IDENTIFICADO');

			$result = $wsdlVNif->VNifV2($contribuyente);
			$this->assertInstanceOf(Contribuyente::class, $result);
			$this->assertEquals($contribuyente, $result);

			$contribuyentes = Contribuyentes::create(
				Contribuyente::create('99999972C', '', 'NO IDENTIFICADO'),
				Contribuyente::create('99999999R', '', 'NO IDENTIFICADO'),
			);

			$result = $wsdlVNif->VNifV2($contribuyentes);
			$this->assertInstanceOf(Contribuyentes::class, $result);
			$this->assertEquals($contribuyentes, $result);
		}
  }
