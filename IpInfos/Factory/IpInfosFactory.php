<?php

namespace Lidaa\IpInfosBundle\IpInfos\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;

class IpInfosFactory extends AbstractIpInfosFactory
{
    private $type = null;
    private $ip = null;
    private $licenseKey = null;

    public function __construct(ContainerInterface $container)
    {
        $this->type = $container->getParameter('lidaa_ipinfos.type');
        $this->licenseKey = $container->getParameter('lidaa_ipinfos.licensekey');

        if (!$this->ip = $container->getParameter('lidaa_ipinfos.ip')) {
            $this->ip = $container->get('request')->getClientIp();
        }
    }

    public function createIpInfos()
    {
        if ($this->type == "ipinfodb") {
            return $this->createIpinfodb();
        } elseif ($this->type == "ipaddresslabs") {
            return $this->createIpaddresslabs();
        } else {
            throw new \Exception("'" . $this->type . "' not supported type");
        }
    }

    private function createIpinfodb()
    {
        return new \Lidaa\IpInfosBundle\IpInfos\IpInfoDb($this->ip, $this->licenseKey);
    }

    private function createIpaddresslabs()
    {
        $ipAddressLabs = new \Lidaa\IpInfosBundle\IpInfos\IpAddressLabs($this->ip, $this->licenseKey);

        return $ipAddressLabs;
    }

}
