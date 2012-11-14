<?php

namespace Lidaa\IpInfosBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class IpInfosExtension extends \Twig_Extension
{
    private $ipInfosHelper;

    public function __construct(ContainerInterface $container)
    {
        $this->ipInfosHelper = $container->get('templating.helper.lidaa_ipinfos');
    }

    public function getFunctions()
    {
        $fonctions = array();

        $fonctions['ipinfos_get_host'] = new \Twig_Function_Method($this, 'getHost');
        $fonctions['ipinfos_get_ip'] = new \Twig_Function_Method($this, 'getIp');
        $fonctions['ipinfos_get_*'] = new \Twig_Function_Method($this, 'getProperty');

        return $fonctions;
    }

    public function getHost()
    {
        return $this->ipInfosHelper->getHost();
    }

    public function getIp()
    {
        return $this->ipInfosHelper->getIp();
    }

    public function getProperty()
    {
        $arg_list = func_get_args();
        $function = array_shift($arg_list);
        $function = 'get' . ucfirst($function);

        return call_user_func_array(array($this->ipInfosHelper, $function), array());
    }

    public function getName()
    {
        return 'lidaa.ipinfos';
    }

}
