<?php

namespace Lidaa\IpInfosBundle\IpInfos;


class IpAddressLabs extends Base\IpInfos
{
    private $licenceKey = null;
    protected $tabMapping = array(
        'isp' => 'isp',
        'country' => 'country_name',
        'city' => 'city',
        'latitude' => 'latitude',
        'longitude' => 'longitude'
    );

    public function __construct($ip, $licence_key)
    {
        $this->setLicenceKey($licence_key);
        parent::__construct($ip);
    }

    public function getLicenceKey()
    {
        return $this->licenceKey;
    }

    public function setLicenceKey($licenceKey)
    {
        $this->licenceKey = $licenceKey;
    }

    protected function fillInfos()
    {
        if (preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $this->ip)) {
            $request = sprintf('http://services.ipaddresslabs.com/iplocation/locateip?key=%s&ip=%s', $this->licenceKey, $this->ip);

            $xmlResult = file_get_contents($request);

            $arrayResult = $this->parseResult($xmlResult);

            $this->tabResult = $arrayResult;
        }
    }

    private function parseResult($chr)
    {
        $data = array();
        $document_xml = new \DomDocument();
        $document_xml->loadXML($chr);

        if ($document_xml->hasChildNodes()) {
            foreach ($this->tabMapping as $key => $value) {
                ${'node_list_' . $key} = $document_xml->getElementsByTagName($value);
                ${'element_' . $key} = ${'node_list_' . $key}->item(0);

                if (${'element_' . $key} instanceof \DOMElement) {
                    $data[$key] = ${'element_' . $key}->nodeValue;
                }
            }
        }

        return $data;
    }

}