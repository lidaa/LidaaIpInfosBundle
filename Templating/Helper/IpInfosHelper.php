<?php

namespace Lidaa\IpInfosBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Lidaa\IpInfosBundle\IpInfos\Factory\AbstractIpInfosFactory;

class IpInfosHelper extends Helper
{
    private $ipInfos;

    public function __construct(AbstractIpInfosFactory $ip_infos_factory)
    {
        $this->ipInfos = $ip_infos_factory->createIpInfos();
    }

    public function getHost()
    {
        return $this->ipInfos->getHost();
    }

    public function getIp()
    {
        return $this->ipInfos->getIp();
    }

    public function __call($name, $arguments = array())
    {
        return $this->ipInfos->{$name}();
    }

    public function getName()
    {
        return 'lidaa.ipinfos';
    }

}