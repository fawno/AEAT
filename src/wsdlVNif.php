<?php
/*
  Copyright 2018, Fawno (https://github.com/fawno)

  Licensed under The MIT License
  Redistributions of files must retain the above copyright notice.

  @copyright Copyright 2018, Fawno (https://github.com/fawno)
  @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/

  namespace Fawno\AEAT;

  use SoapClient;

  class wsdlVNif extends SoapClient {
    protected $wsdl = 'https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/burt/jdit/ws/VNifV2.wsdl';
    protected $location = 'https://www1.agenciatributaria.gob.es/wlpl/BURT-JDIT/ws/VNifV2SOAP';

    public function __construct ($local_cert, $passphrase, $options = [], $ssl_verifypeer = true) {
      $options += [
        'local_cert' => $local_cert,
        'passphrase' => $passphrase,
        'stream_context' => [
          'http' => [
            'user_agent' => 'PHPSoapClient',
          ],
          'ssl' => [
            'ciphers' => 'DEFAULT@SECLEVEL=1',
          ],
        ],
      ];

      $options['stream_context'] = $this->stream_context($options['stream_context'], $ssl_verifypeer);

      return parent::__construct($this->wsdl, $options);
    }

    protected function stream_context ($options = [], $ssl_verifypeer = true) {
      switch (gettype($options)) {
        case 'array':
          $context = stream_context_create($options);
          break;
        case 'resource':
          $context = $options;
      }

      if (!$ssl_verifypeer) {
        stream_context_set_option($context, [
          'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
          ],
        ]);
      }

      return $context;
    }

    public function __doRequest ($request, $location, $action, $version, $one_way = 0) {
      return parent::__doRequest($request, $this->location, $action, $version, $one_way);
    }

    public function VNif ($contribuyentes) {
      return $this->VNifV2($contribuyentes);
    }

    public function VNifV2 ($contribuyentes) {
      return $this->__soapCall('VNifV2', [['Contribuyente' => $contribuyentes]]);
    }

    public static function nif_validation ($nif) {
      if (preg_match('~(ES)?([\w\d]{9})~', strtoupper($nif), $parts)) {
        $nif = end($parts);
        if (preg_match('~(^[XYZ\d]\d{7})([TRWAGMYFPDXBNJZSQVHLCKE]$)~', $nif, $parts)) {
          $control = 'TRWAGMYFPDXBNJZSQVHLCKE';
          $nie = ['X', 'Y', 'Z'];
          $parts[1] = str_replace(array_values($nie), array_keys($nie), $parts[1]);
          $cheksum = substr($control, $parts[1] % 23, 1);
          return ($parts[2] == $cheksum);
        } elseif (preg_match('~(^[ABCDEFGHIJKLMUV])(\d{7})(\d$)~', $nif, $parts)) {
          $checksum = 0;
          foreach (str_split($parts[2]) as $pos => $val) {
            $checksum += array_sum(str_split($val * (2 - ($pos % 2))));
          }
          $checksum = ((10 - ($checksum % 10)) % 10);
          return ($parts[3] == $checksum);
        } elseif (preg_match('~(^[KLMNPQRSW])(\d{7})([JABCDEFGHI]$)~', $nif, $parts)) {
          $control = 'JABCDEFGHI';
          $checksum = 0;
          foreach (str_split($parts[2]) as $pos => $val) {
            $checksum += array_sum(str_split($val * (2 - ($pos % 2))));
          }
          $checksum = substr($control, ((10 - ($checksum % 10)) % 10), 1);
          return ($parts[3] == $checksum);
        }
      }
      return false;
    }
  }
