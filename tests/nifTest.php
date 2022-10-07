<?php
  declare(strict_types=1);

  namespace Fawno\AEAT\Tests;

  use PHPUnit\Framework\TestCase;
  use Fawno\AEAT\wsdlVNif;

  class nifTest extends TestCase {
		public function testValidNif () {
			$nifs = [
				'34121374T',
				'73736715A',
				'61241297W',
				'96364992Y',
				'89863275K',
			];

			foreach ($nifs as $nif) {
				$result = wsdlVNif::nif_validation($nif);
				$this->assertTrue($result, sprintf('Check valid %s fail', $nif));
			}
		}

		public function testInvalidNif () {
			$nifs = [
				'34121373T',
				'73736713A',
				'61241293W',
				'96364993Y',
				'89863273K',
			];

			foreach ($nifs as $nif) {
				$result = wsdlVNif::nif_validation($nif);
				$this->assertFalse($result, sprintf('Check valid %s fail', $nif));
			}
		}

		public function testValidCif () {
			$nifs = [
				'Q0688620D',
				'D10036366',
				'H20577870',
				'R2259759E',
				'F26897785',
			];

			foreach ($nifs as $nif) {
				$result = wsdlVNif::nif_validation($nif);
				$this->assertTrue($result, sprintf('Check valid %s fail', $nif));
			}
		}

		public function testInvalidCif () {
			$nifs = [
				'Q0688610D',
				'D10036566',
				'H20577670',
				'R2259789E',
				'F26897185',
			];

			foreach ($nifs as $nif) {
				$result = wsdlVNif::nif_validation($nif);
				$this->assertFalse($result, sprintf('Check valid %s fail', $nif));
			}
		}

		public function testValidNie () {
			$nifs = [
				'X2961377N',
				'Z0743371Q',
				'X1555811E',
				'Z4273267X',
				'Z4134508X',
			];

			foreach ($nifs as $nif) {
				$result = wsdlVNif::nif_validation($nif);
				$this->assertTrue($result, sprintf('Check valid %s fail', $nif));
			}
		}

		public function testInvalidNie () {
			$nifs = [
				'X2961373N',
				'Z0743372Q',
				'X1555814E',
				'Z4273265X',
				'Z4134506X',
			];

			foreach ($nifs as $nif) {
				$result = wsdlVNif::nif_validation($nif);
				$this->assertFalse($result, sprintf('Check valid %s fail', $nif));
			}
		}
  }
