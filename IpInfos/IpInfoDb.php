<?php

namespace Lidaa\IpInfosBundle\IpInfos;

class IpInfoDb extends Base\IpInfos
{
    private $licenceKey = null;
    protected $tabMapping = array(
        'countrycode' => 'countryCode',
        'country' => 'countryName',
        'region' => 'regionName',
        'city' => 'cityName',
        'latitude' => 'latitude',
        'longitude' => 'longitude',
        'timezone' => 'timeZone'
    );

    public function __construct($ip, $licence_key)
    {
        $this->setLicenceKey($licence_key);
        parent::__construct($ip);
    }

    public function setLicenceKey($licenceKey)
    {
        $this->licenceKey = $licenceKey;
    }

    public function getLicenceKey()
    {
        return $this->licenceKey;
    }

    protected function fillInfos()
    {
        $ipLite = new ip2location_lite;
        $ipLite->setKey($this->getLicenceKey());

        $xmlResult = $ipLite->getCity($this->ip);

        $arrayResult = $this->parseResult($xmlResult);

        $this->tabResult = $arrayResult;
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

final class ip2location_lite
{
    protected $errors = array();
    protected $service = 'api.ipinfodb.com';
    protected $version = 'v3';
    protected $apiKey = '';

    public function setKey($key)
    {
        if (!empty($key))
            $this->apiKey = $key;
    }

    public function getError()
    {
        return implode("\n", $this->errors);
    }

    public function getCountry($host)
    {
        return $this->getResult($host, 'ip-country');
    }

    public function getCity($host)
    {
        return $this->getResult($host, 'ip-city');
    }

    private function getResult($host, $name)
    {
        $ip = @gethostbyname($host);

        if (preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)) {
            $xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');
            
            return $xml;
        }

        throw new \InvalidArgumentException('"' . $host . '" is not a valid IP address or hostname.');
    }

}