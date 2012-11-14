<?php

namespace Lidaa\IpInfosBundle\IpInfos\Base;

class IpInfos
{
    protected $ip;
    protected $host;
    protected $tabResult = array();
    protected $tabMapping = array();

    public function __construct($ip)
    {
        $this->ip = $ip;
        $this->host = gethostbyaddr($ip);
    }

    public function getIp() {
        return $this->ip;
    }

    public function getHost() {
        return $this->host;
    }

    public function __call($name, $arguments = array())
    {
        $property = strtolower(substr($name, 3));

        if (!array_key_exists($property, $this->tabMapping)) {
            $msg = sprintf("Unrecognized option '%s', options: 'ip', 'host', '%s'.", $property, implode("', '", array_keys($this->tabMapping)));
            throw new \InvalidArgumentException($msg);
        }

        if (!count($this->tabResult)) {
            $this->fillInfos();
        }

        return key_exists($property, $this->tabResult) ? $this->tabResult[$property] : "";
    }

    protected function fillInfos()
    {
        $this->tabResult = array();
        $this->tabMapping = array();
    }

}