<?php

class m170217_131330_register extends CDbMigration
{
	public function up()
	{
		$this->execute("alter table cb_dev_groots.retailer add column registration_status enum ('OTPVerificationPending', 'ProductMappingPending', 'Complete')");

		$this->execute("alter table cb_dev_groots.retailer_log add column registration_status enum ('OTPVerificationPending', 'ProductMappingPending', 'Complete')");

		$this->execute("CREATE TABLE cb_dev_groots.`user_otps` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL,
		  `otp` varchar(10) NOT NULL,
		  `expires_at` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  KEY `fk_us_otps_1` (`user_id`),
		  CONSTRAINT `fk_us_otps_1` FOREIGN KEY (`user_id`) REFERENCES cb_dev_groots.`retailer` (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1");

		$this->execute("alter table cb_dev_groots.base_product add column is_sample tinyint(4) default 0");
	}

	public function down()
	{
		echo "m170217_131330_register does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}