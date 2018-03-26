

CREATE TABLE vstore_cart (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_session` varchar(250) DEFAULT NULL,
  `cart_e107_user` varchar(250) DEFAULT NULL,
  `cart_status` varchar(250) DEFAULT NULL,
  `cart_item` int(11) DEFAULT NULL,
	`cart_item_vars` text NOT NULL,
  `cart_qty` int(11) DEFAULT NULL,
  `cart_paystat` varchar(250) DEFAULT NULL,
  `cart_paydate` varchar(250) DEFAULT NULL,
  `cart_paytrans` varchar(250) DEFAULT NULL,
  `cart_paygross` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cart_payshipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cart_payshipto` text NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM;



CREATE TABLE vstore_orders (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` int(10) DEFAULT NULL,
  `order_session` varchar(250) DEFAULT NULL,
  `order_e107_user` int(6) DEFAULT NULL,
  `order_cust_id` int(6) DEFAULT NULL,
  `order_status` varchar(1) DEFAULT NULL,
  `order_items` text NOT NULL,
	`order_refcode` varchar(20) NOT NULL,
	`order_billing` text NOT NULL,
	`order_use_shipping` tinyint(1) NULL DEFAULT NULL,
	`order_shipping` text NOT NULL,
  `order_pay_gateway` varchar(50) DEFAULT NULL,
  `order_pay_status` varchar(250) DEFAULT NULL,
  `order_pay_transid` varchar(250) DEFAULT NULL,
  `order_pay_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_pay_coupon_code` varchar(50) DEFAULT NULL,
  `order_pay_coupon_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_pay_shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_pay_rawdata` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM;


CREATE TABLE vstore_cat (
  `cat_id` int(5) NOT NULL AUTO_INCREMENT,
	`cat_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `cat_parent` int(5) NOT NULL DEFAULT '0',
  `cat_name` varchar(250) DEFAULT NULL,
  `cat_description` varchar(250) DEFAULT NULL,
  `cat_sef` varchar(127) DEFAULT NULL,
  `cat_image` varchar(250) DEFAULT NULL,
  `cat_info` text NOT NULL,
  `cat_class` varchar(12) NOT NULL DEFAULT '',
  `cat_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM;


CREATE TABLE vstore_items (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
	`item_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `item_code` varchar(10) NOT NULL DEFAULT '',
  `item_name` varchar(127) DEFAULT NULL,
  `item_keywords` varchar(127) DEFAULT NULL,
  `item_desc` varchar(250) DEFAULT NULL,
  `item_cat` tinyint(4) DEFAULT NULL,
  `item_pic` text NOT NULL,
  `item_files` text NOT NULL,
  `item_price` decimal(10,2) DEFAULT NULL,
  `item_shipping` decimal(10,2) DEFAULT NULL,
  `item_weight` decimal(10,2) DEFAULT NULL,
  `item_details` text NOT NULL,
  `item_reviews` text NOT NULL,
  `item_order` tinyint(3) DEFAULT NULL,
  `item_inventory` int(6) DEFAULT NULL,
  `item_vars` varchar(255) DEFAULT NULL,
	`item_vars_inventory` text NOT NULL,
  `item_link` varchar(255) DEFAULT NULL,
  `item_download` varchar(255) DEFAULT NULL,
  `item_related` text NOT NULL,
	`item_userclass` SMALLINT(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM;

CREATE TABLE vstore_items_vars (
  `item_var_id` int(10) NOT NULL AUTO_INCREMENT,
  `item_var_name` varchar(255) NOT NULL DEFAULT '',
  `item_var_info` varchar(255) NOT NULL DEFAULT '',
  `item_var_attributes` text NOT NULL,
  `item_var_compulsory` int(2) NOT NULL DEFAULT '0',
  `item_var_userclass` int(4) NOT NULL,
  PRIMARY KEY (`item_var_id`)
) ENGINE=MyISAM;

CREATE TABLE vstore_coupons (
	`coupon_id` int(11) NOT NULL AUTO_INCREMENT,
	`coupon_active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
	`coupon_code` varchar(50) NOT NULL,
	`coupon_type` char(1) NOT NULL,
	`coupon_amount` decimal(10,2) NULL DEFAULT NULL,
	`coupon_start` int(10) NULL DEFAULT NULL,
	`coupon_end` int(10) NULL DEFAULT NULL,
	`coupon_items` text NOT NULL,
	`coupon_items_ex` text NOT NULL,
	`coupon_cats` text NOT NULL,
	`coupon_cats_ex` text NOT NULL,
	`coupon_limit_coupon` int(10) NULL DEFAULT NULL,
	`coupon_limit_item` int(10) NULL DEFAULT NULL,
	`coupon_limit_user` int(10) NULL DEFAULT NULL,
	PRIMARY KEY (`coupon_id`),
	UNIQUE INDEX `coupon_code` (`coupon_code`)
) ENGINE=MyISAM;


CREATE TABLE vstore_customer (
	`cust_id` INT(11) NOT NULL AUTO_INCREMENT,
	`cust_e107_user` INT(6) NULL DEFAULT NULL,
	`cust_datestamp` INT(10) NULL DEFAULT NULL,
	`cust_title` varchar(50) NULL DEFAULT NULL,
	`cust_firstname` varchar(100) NULL DEFAULT NULL,
	`cust_lastname` varchar(100) NULL DEFAULT NULL,
	`cust_company` varchar(100) NULL DEFAULT NULL,
	`cust_vat_id` varchar(100) NULL DEFAULT NULL,
	`cust_taxcode` varchar(100) NULL DEFAULT NULL,
	`cust_address` varchar(255) NULL DEFAULT NULL,
	`cust_city` varchar(100) NULL DEFAULT NULL,
	`cust_state` varchar(100) NULL DEFAULT NULL,
	`cust_zip` varchar(20) NULL DEFAULT NULL,
	`cust_country` varchar(100) NULL DEFAULT NULL,
	`cust_email` varchar(100) NULL DEFAULT NULL,
	`cust_phone` varchar(50) NULL DEFAULT NULL,
	`cust_fax` varchar(50) NULL DEFAULT NULL,
	`cust_notes` text NOT NULL,
	`cust_refcode` varchar(20) NULL DEFAULT NULL,
	`cust_gateway` varchar(50) NULL DEFAULT NULL,
	`cust_additional_fields` text NULL,
	`cust_use_shipping` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
	`cust_shipping` text NOT NULL,
	PRIMARY KEY (`cust_id`),
	UNIQUE INDEX `cust_e107_user` (`cust_e107_user`)
)
ENGINE=MyISAM;
