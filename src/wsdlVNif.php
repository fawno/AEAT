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
      $options['local_cert'] = $local_cert;
      $options['passphrase'] = $passphrase;
      if (empty($options['stream_context'])) {
        $options['stream_context'] = $this->stream_context($ssl_verifypeer);
      }

      return parent::__construct($this->wsdl, $options);
    }

    protected function stream_context ($ssl_verifypeer = true, $options = []) {
      $options['http']['user_agent'] = 'PHPSoapClient';
      if (!$ssl_verifypeer) {
        $options['ssl']['verify_peer'] = false;
        $options['ssl']['verify_peer_name'] = false;
        $options['ssl']['allow_self_signed'] = true;
      }

      return stream_context_create($options);
    }

    public function __doRequest ($request, $location, $action, $version, $one_way = 0) {
      return parent::__doRequest($request, $this->location, $action, $version, $one_way);
    }

    public function VNifV2 ($contribuyentes) {
      return $this->__soapCall('VNifV2', [['Contribuyente' => $contribuyentes]]);
    }
  }
