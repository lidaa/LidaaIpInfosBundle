# LidaaIpInfosBundle
-----

### Requirement

- Symfony version 2.0.9 or later (2.0.x)

### Installation

**1- Add the following lines in your deps file:**  

    [LidaaTransBundle]
        git=git://github.com/lidaa/LidaaIpInfosBundle.git
        target=/bundles/Lidaa/IpInfosBundle

**2- Now, run the vendors script to download the bundle:**

	$ php bin/vendors install

**3- Add LidaaTransBundle to your application kernel:**

	// app/AppKernel.php
	public function registerBundles()
	{
		 return array(
		     // ...
		     new Lidaa\IpInfosBundle\LidaaIpInfosBundle(),
		     // ...
		 );
	}

**4- Add the 'Lidaa' namespace to your autoloader:**

	// app/autoload.php
	$loader->registerNamespaces(array(
		 //...
		 'Lidaa' => __DIR__.'/../vendor/bundles',
		 //...
	));

### Configuration

    lidaa_ip_infos:
      type: ipinfodb        # ipinfodb OR ipaddresslabs
      ip: ~                 # You can spacify an address IP
      license_key: demo     # Your key licence

### Usage

    In your twig file, you can use a lot of functions to display informationS of Ip address.
    Examples:
      {{ ipinfos_get_ip() }}  =>  154.32.55.2
      {{ ipinfos_get_host() }}  =>  pc-host-name
      {{ ipinfos_get_city() }}  =>  Casablanca
      ...

enjoy :)




