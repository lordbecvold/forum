<?php // define site config

	namespace becwork\config;

	class PageConfig {

		public $config = [

			/* Main config */
			"appName"     => "Forum",			 //Define app name
			"version"     => 1.0,                  	 //Define app version
			"author"      => "Lukáš Bečvář",       	 //Define app author
			"authorLink"  => "https://becvold.xyz/", //Define author site
			"dev_mode"    => true,					 //Define devmode enabled
			"url"         => "localhost",   		 //Define main app url
			"encoding"    => "utf8",               	 //Define default charset
			"https"       => false,				   	 //If this = true (Site can run only on https://)

			/* Page config */
			"maintenance" => false,	//Define maintenance status

			/*	Mysql config	*/
			"ip" 		=> 	"localhost", 	//Define mysql server ip
			"basedb" 	=> 	"forum",  	//Define mysql default db name
			"username"	=> 	"root", 		//Define mysql user 
			"password" 	=> 	"root"			//Define Mysql password
		];
	}
?>