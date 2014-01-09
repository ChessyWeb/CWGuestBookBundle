CWGuestBookBundle
=================

Guest Book bundle for Symfony 2.x, handling message submission, mail notification, message validation, etc.

[![Build Status](https://travis-ci.org/ChessyWeb/CWGuestBookBundle.png?branch=master)](https://travis-ci.org/ChessyWeb/CWGuestBookBundle)

![SensioLabs Insight Rating](https://insight.sensiolabs.com/projects/29cdf30c-dbec-4f9f-b13a-63c6620a00d3/big.png)

Installation
-----------------

###Composer (soon)

Configuration
-------------

Register the bundle:


    <?php
    // app/AppKernel.php
	public function registerBundles()
	{
	    $bundles = array(
	        // ...
	        new ChessyWeb\Bundle\GuestBook\ChessyWebGuestBookBundle(),
	    );
	    // ...
	}
	
TODO
----
- Enable translation
- Add tests with PhpUnit for Travis CI build.
- Add repo to Packagist, so that it will be available for Composer
