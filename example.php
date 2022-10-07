<?php
  require __DIR__ . '/autoload.php';

  use Fawno\AEAT\wsdlVNif;

	$nif = '50869902C';
	$result = wsdlVNif::nif_validation($nif) ? 'Valid' : 'Invalid';
	echo sprintf('%s is %s', $nif, $result), PHP_EOL;

	$nif = 'B13384599';
	$result = wsdlVNif::nif_validation($nif) ? 'Valid' : 'Invalid';
	echo sprintf('%s is %s', $nif, $result), PHP_EOL;

	$nif = 'X2600858H';
	$result = wsdlVNif::nif_validation($nif) ? 'Valid' : 'Invalid';
	echo sprintf('%s is %s', $nif, $result), PHP_EOL;
