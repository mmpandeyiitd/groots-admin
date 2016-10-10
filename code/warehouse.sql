
insert into cb_dev_groots.warehouses values(null, 'Azadpur, delhi', null, 'Azadpur, delhi', 'Delhi', 'Delhi', 'Azadpur', '110033', null, null,null,1,now(), now(),null);





/*
ALTER TABLE cb_dev_groots.base_product ADD COLUMN parent_id int(11) unsigned DEFAULT NULL , add index fk_base_prod_1 (parent_id), add CONSTRAINT fk_base_prod_1 foreign key (parent_id) REFERENCES cb_dev_groots.base_product(base_product_id);*/


CREATE TABLE cb_dev_groots.`vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `vendor_code` varchar(10) DEFAULT NULL,
  `VAT_number` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `geolocation` varchar(255) DEFAULT NULL,
  `owner_phone` varchar(10) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `settlement_days` varchar(255) DEFAULT NULL,
  `time_of_delivery` varchar(255) DEFAULT NULL,
  `date_of_onboarding` datetime NOT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `image_url` text,
  `website` varchar(250) DEFAULT NULL,
  `contact_person1` varchar(250) DEFAULT NULL,
  `contact_person2` varchar(250) DEFAULT NULL,
  `product_categories` text,
  `categories_of_interest` varchar(250) DEFAULT NULL,
  `store_size` int(10) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `credit_limit` int(155) DEFAULT NULL,
  `created_date` DATETIME NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `min_order_price` float DEFAULT NULL,
  `shipping_charge` float DEFAULT NULL,
  `allocated_warehouse_id` int(11) unsigned NOT NULL DEFAULT '1',
  `initial_pending_amount` decimal(10,2) DEFAULT NULL,
  `total_pending_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendor_1` (`allocated_warehouse_id`),
  CONSTRAINT `fk_vendor_1` FOREIGN KEY (`allocated_warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

CREATE TABLE groots_orders.`purchase_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `payment_method` enum('cod','paytm','tpsl','prepay','tbd','paas','pay later','pay \r\n\r\nnow','operator billing','payu') DEFAULT NULL,
  `payment_status` enum('pending','partial_paid','success','failed') DEFAULT NULL,
  `status` enum('pending','received','failed', 'cancelled') DEFAULT NULL,
  `delivery_date` date NOT NULL,
  `total_payable_amount` decimal(10,2) DEFAULT NULL,
  `comment` text,
  `invoice_number` varchar(255) DEFAULT NULL,
  created_at date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX fk_purchase_hd_1 (warehouse_id),
  INDEX fk_purchase_hd_2 (vendor_id),
  CONSTRAINT fk_purchase_hd_1 FOREIGN KEY (warehouse_id) REFERENCES cb_dev_groots.warehouses(id),
  CONSTRAINT fk_purchase_hd_2 FOREIGN KEY (vendor_id) REFERENCES cb_dev_groots.vendors(id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




CREATE TABLE groots_orders.`purchase_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `base_product_id` int(11) UNSIGNED NOT NULL,
  `colour` varchar(30) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `diameter` varchar(255) DEFAULT NULL,
  `pack_size` float DEFAULT NULL,
  `pack_unit` varchar(20) DEFAULT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `weight_unit` varchar(10) DEFAULT NULL,
  `length` decimal(10,4) DEFAULT NULL,
  `length_unit` varchar(10) DEFAULT NULL,
  `order_qty` decimal(10,2) DEFAULT NULL,
  `received_qty` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','Confirmed','ReturnedRequested','Cancelled','returned') CHARACTER SET utf8 DEFAULT 'pending',
  created_at date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX fk_purchase_line_1 (purchase_id),
  INDEX fk_purchase_line_2 (base_product_id),
  CONSTRAINT fk_purchase_line_1 FOREIGN KEY (purchase_id) REFERENCES groots_orders.purchase_header(id),
  CONSTRAINT fk_purchase_line_2 FOREIGN KEY (base_product_id) REFERENCES cb_dev_groots.base_product(base_product_id)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;




ALTER TABLE groots_orders.order_line  MODIFY  COLUMN  `subscribed_product_id` int(11) UNSIGNED NOT NULL;
ALTER TABLE groots_orders.order_line add INDEX fk_order_line_1 (order_id), add INDEX fk_order_line_2 (subscribed_product_id);
ALTER TABLE groots_orders.order_line add CONSTRAINT fk_order_line_1 FOREIGN KEY (order_id) REFERENCES groots_orders.order_header(order_id);
ALTER TABLE groots_orders.order_line add CONSTRAINT fk_order_line_2 FOREIGN KEY (subscribed_product_id) REFERENCES cb_dev_groots.subscribed_product(subscribed_product_id);


CREATE TABLE groots_orders.`transfer_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_warehouse_id` int(11) UNSIGNED NOT NULL,
  `dest_warehouse_id` int(11) UNSIGNED NOT NULL,
  `status` enum('pending','received','failed', 'cancelled') DEFAULT NULL,
  `delivery_date` date NOT NULL,
  `comment` text,
  `invoice_number` varchar(255) DEFAULT NULL,
  created_at date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX fk_transfer_hd_1 (source_warehouse_id),
  INDEX fk_transfer_hd_2 (dest_warehouse_id),
  CONSTRAINT fk_transfer_hd_1 FOREIGN KEY (source_warehouse_id) REFERENCES cb_dev_groots.warehouses(id),
  CONSTRAINT fk_transfer_hd_2 FOREIGN KEY (dest_warehouse_id) REFERENCES cb_dev_groots.warehouses(id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




CREATE TABLE groots_orders.`transfer_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `base_product_id` int(11) UNSIGNED NOT NULL,
  `colour` varchar(30) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `diameter` varchar(255) DEFAULT NULL,
  `pack_size` float DEFAULT NULL,
  `pack_unit` varchar(20) DEFAULT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `weight_unit` varchar(10) DEFAULT NULL,
  `length` decimal(10,4) DEFAULT NULL,
  `length_unit` varchar(10) DEFAULT NULL,
  `order_qty` decimal(10,2) DEFAULT NULL,
  `delivered_qty` decimal(10,2) DEFAULT NULL,
  `received_qty` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','Confirmed','ReturnedRequested','Cancelled','returned') CHARACTER SET utf8 DEFAULT 'pending',
  created_at datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX fk_tranfer_line_1 (transfer_id),
  INDEX fk_tranfer_line_2 (base_product_id),
  CONSTRAINT fk_tranfer_line_1 FOREIGN KEY (transfer_id) REFERENCES groots_orders.transfer_header(id),
  CONSTRAINT fk_tranfer_line_2 FOREIGN KEY (base_product_id) REFERENCES cb_dev_groots.base_product(base_product_id)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;


ALTER TABLE cb_dev_groots.base_product add COLUMN popularity SMALLINT DEFAULT 5;

alter table groots_orders.purchase_header add column `paid_amount` decimal(10,2) DEFAULT NULL;



CREATE TABLE groots_orders.`inventory_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) UNSIGNED NOT NULL,
  `base_product_id` int(11) UNSIGNED NOT NULL,
  schedule_inv decimal(10,2) DEFAULT NULL,
  schedule_inv_type enum('percents', 'days') default 'days',
  extra_inv decimal(10,2) DEFAULT NULL,
  extra_inv_type enum('percents', 'days') default 'percents',
  created_at datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX fk_inv_1 (warehouse_id),
  INDEX fk_inv_2 (base_product_id),
  CONSTRAINT fk_inv_1 FOREIGN KEY (warehouse_id) REFERENCES cb_dev_groots.warehouses(id),
  CONSTRAINT fk_inv_2 FOREIGN KEY (base_product_id) REFERENCES cb_dev_groots.base_product(base_product_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE groots_orders.`inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_id` int(11) NOT NULL,
  `warehouse_id` int(11) UNSIGNED NOT NULL,
  `base_product_id` int(11) UNSIGNED NOT NULL,
  schedule_inv decimal(10,2) DEFAULT NULL,
  present_inv decimal(10,2) DEFAULT NULL,
  wastage decimal(10,2) DEFAULT NULL,
  extra_inv decimal(10,2) DEFAULT NULL,
  inv_change_type VARCHAR(255) DEFAULT NULL ,
  inv_change_id int(11) NOT NULL,
  inv_change_quantity decimal(10,2) DEFAULT NULL ,
  date DATE DEFAULT  NULL,
  created_at DATETIME NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX fk_inv_hist_1 (inv_id),
  CONSTRAINT fk_inv_hist_1 FOREIGN KEY (inv_id) REFERENCES groots_orders.inventory(id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


alter table groots_orders.inventory modify column `inv_change_id` int(11) default NULL;

insert into groots_orders.inventory_header select null, 1, base_product_id, 2, 'days', 15, 'percents', now(), now() from cb_dev_groots.base_product;

insert into groots_orders.inventory  select null,ih.id, ih.warehouse_id,ih.base_product_id, 2,0,0,0,null,1, 0, now(), now(), now() from cb_dev_groots.base_product bp join groots_orders.inventory_header ih on ih.base_product_id=bp.base_product_id;

ALTER TABLE groots_orders.inventory ADD UNIQUE KEY `uk_inv_1` (`inv_id`,`date`);

ALTER TABLE groots_orders.inventory_header ADD UNIQUE KEY `uk_inv_hd_1` (warehouse_id, `base_product_id`);


/*populate inventory one time*/

insert into groots_orders.inventory  select null,ih.id, ih.warehouse_id,ih.base_product_id, 2,0,0,0,null,1, 0, '2016-09-14', now(), now() from cb_dev_groots.base_product bp join groots_orders.inventory_header ih on ih.base_product_id=bp.base_product_id;

alter table groots_orders.inventory add column `wastage_others` decimal(10,2) DEFAULT NULL;
alter table groots_orders.inventory add column `liquid_inv` decimal(10,2) DEFAULT null;

alter table cb_dev_groots.warehouses add column default_source_warehouse_id int(11) unsigned DEFAULT NULL;
ALTER  TABLE cb_dev_groots.warehouses add index fk_warehouses_1 (default_source_warehouse_id), add constraint fk_warehouses_1 foreign key (default_source_warehouse_id) REFERENCES cb_dev_groots.`warehouses`(id);
update cb_dev_groots.warehouses set default_source_warehouse_id=2;

ALTER  TABLE groots_orders.transfer_header add column transfer_type enum('regular', 'singular') NOT NULL DEFAULT 'singular';
UPDATE groots_orders.transfer_header SET transfer_type='singular';

ALTER  TABLE groots_orders.transfer_header add column transfer_category enum('primary', 'secondary') NOT NULL DEFAULT 'primary';



alter table groots_orders.transfer_line drop column colour, drop column size, drop column grade, drop column diameter, drop column pack_size, drop column pack_unit, drop column weight, drop column weight_unit, drop column length, drop column length_unit, drop column unit_price, drop column price;


rename table cb_dev_groots.users to cb_dev_groots.users1;