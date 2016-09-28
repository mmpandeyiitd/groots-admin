CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY
DEFINER VIEW cb_dev_groots.`retailerproductquotation_gridview` AS select
`sp`.`subscribed_product_id` AS `subscribed_product_id`,`sp`.`base_product_id`
AS `base_product_id`,`bp`.`title` AS
`title`,bp.pack_size,bp.pack_unit,`sp`.`store_price` AS
`store_price`,`sp`.`store_offer_price` AS `store_offer_price`,`sp`.`quantity`
AS `quantity`,`s`.`store_name` AS
`store`,if(isnull(`rp`.`retailer_id`),0,`rp`.`retailer_id`) AS
`retailer_id`,if(isnull(`rp`.`effective_price`),' ',`rp`.`effective_price`) AS
`effective_price`,if(isnull(`rp`.`discount_per`),0,`rp`.`discount_per`) AS
`discount_price`,if(isnull(`rp`.`status`),' 1',`rp`.`status`) AS `status`,
md.media_url, md.thumb_url from (((`subscribed_product` `sp` join
`base_product` `bp` on((`bp`.`base_product_id` = `sp`.`base_product_id`)))
left join `store` `s` on((`s`.`store_id` = `sp`.`store_id`))) left join
`retailer_product_quotation` `rp` on((`rp`.`subscribed_product_id` =
`sp`.`subscribed_product_id`))) left join media md on
(md.base_product_id=bp.base_product_id) where ((`sp`.`status` = 1) and
(`bp`.`status` = 1) );




alter table cb_dev_groots.subscribed_product modify column subscribed_product_id int(11) unsigned NOT NULL AUTO_INCREMENT, modify column `base_product_id` int(11) unsigned NOT NULL, add index fk_sub_prod_1 (base_product_id), add CONSTRAINT fk_sub_prod_1 foreign key (base_product_id) REFERENCES cb_dev_groots.base_product(base_product_id);

CREATE TABLE cb_dev_groots.`product_prices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `base_product_id` int(11) unsigned NOT NULL,
  `subscribed_product_id` int(11) unsigned  NOT NULL,
  `price` int(11) unsigned NOT NULL,
  `effective_date` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT uk_prod_price_1 UNIQUE (base_product_id,subscribed_product_id,price,effective_date),
  INDEX fk_prod_prices_1 (base_product_id),
  INDEX fk_prod_prices_2 (subscribed_product_id),
  CONSTRAINT fk_prod_prices_1 FOREIGN KEY (base_product_id) REFERENCES base_product(base_product_id),
  CONSTRAINT fk_prod_prices_2 FOREIGN KEY (subscribed_product_id) REFERENCES subscribed_product(subscribed_product_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8


/*delete from cb_dev_groots.store where store_id=1;


alter table cb_dev_groots.store  auto_increment=1;*/


CREATE TABLE cb_dev_groots.`warehouses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `locality` varchar(100) DEFAULT NULL,
  `pincode` varchar(100) DEFAULT NULL,
  `mobile_numbers` varchar(100) DEFAULT NULL,
  `telephone_numbers` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


insert into cb_dev_groots.`warehouses` values (null, 'sector-5, warehouse', null, 'sector-5, warehouse', 'Haryana', 'Gurgaon', 'Sector-5', 122001, null, null, null, 1, now(),now(),null);

alter table cb_dev_groots.retailer add column allocated_warehouse_id int(11) unsigned NOT NULL DEFAULT 1, add index fk_retailer_1 (allocated_warehouse_id), add constraint fk_retailer_1 foreign key (allocated_warehouse_id) REFERENCES cb_dev_groots.`warehouses`(id);





CREATE TABLE cb_dev_groots.`addresses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  entity_type enum('retailer', 'order') NOT NULL,
  `entity_id` int(11) NOT NULL,
  `address_line_1` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(11) DEFAULT NULL,
  phone varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




alter table groots_orders.order_header modify column `invoice_number` varchar(255) DEFAULT NULL

update groots_orders.order_header oh  left join cb_dev_groots.retailer r on r.id=oh.user_id  set oh.user_id=1 where r.id is null;


alter table groots_orders.order_header add column billing_address_id int(10) DEFAULT NULL, add column shipping_address_id int(10) default NULL, add index fk_order_1 (user_id), add index fk_order_2 (billing_address_id), add index fk_order_3 (shipping_address_id)


alter table groots_orders.order_header add CONSTRAINT fk_order_1 foreign key (user_id) REFERENCES cb_dev_groots.retailer(id);

  alter table groots_orders.order_header add CONSTRAINT fk_order_2 foreign key (billing_address_id) REFERENCES cb_dev_groots.addresses(id);

alter table groots_orders.order_header add CONSTRAINT fk_order_3 foreign key (shipping_address_id) REFERENCES cb_dev_groots.addresses(id);


alter table groots_orders.order_header add column warehouse_id int(11) unsigned NOT NULL DEFAULT 1, add index fk_order_4 (warehouse_id), add constraint fk_order_4 foreign key (warehouse_id) REFERENCES cb_dev_groots.`warehouses`(id);

update cb_dev_groots.store set store_name="GROOTS FOOD VENTURE PRIVATE LIMITED";

alter table cb_dev_groots.product_prices add column `store_price` decimal(12,2) NOT NULL DEFAULT '0.00' after subscribed_product_id;

alter table cb_dev_groots.product_prices change column price `store_offer_price` decimal(12,2) NOT NULL DEFAULT '0.00';

ALTER TABLE cb_dev_groots.product_prices   DROP INDEX uk_prod_price_1,   ADD UNIQUE KEY `uk_prod_price_1` (`base_product_id`,`subscribed_product_id`,`effective_date`)

alter table groots_orders.order_line add column  delivered_qty decimal(10,2) DEFAULT NULL AFTER product_qty;



alter table cb_dev_groots.retailer add column initial_payable_amount decimal(10,2) DEFAULT NULL, add COLUMN total_payable_amount decimal(10,2) DEFAULT NULL;

CREATE TABLE groots_orders.`retailer_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retailer_id` int(11)  NOT NULL,
  paid_amount decimal(10,2) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  payment_type enum('Cash', 'Cheque', 'DemandDraft', 'OnlineTransfer') NOT NULL DEFAULT 'Cash',
  cheque_no VARCHAR(256) DEFAULT NULL,
  comment TEXT DEFAULT NULL,
  created_at date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX fk_rt_pm_1 (retailer_id),
  CONSTRAINT fk_rt_pm_1 FOREIGN KEY (retailer_id) REFERENCES cb_dev_groots.retailer(id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

alter table groots_orders.`retailer_payments` add COLUMN  status SMALLINT(4) NOT NULL DEFAULT 1;

--------------------------------------



insert into cb_dev_groots.warehouses values(null, 'Azadpur, delhi', null, 'Azadpur, delhi', 'Delhi', 'Delhi', 'Azadpur', '110033', null, null,null,1,now(), now(),null);


  alter table groots_orders.order_line add COLUMN received_quantity decimal(10,2) DEFAULT NULL;


ALTER TABLE cb_dev_groots.base_product ADD COLUMN parent_id int(11) unsigned DEFAULT NULL , add index fk_base_prod_1 (parent_id), add CONSTRAINT fk_base_prod_1 foreign key (parent_id) REFERENCES cb_dev_groots.base_product(base_product_id);


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
ALTER TABLE groots_orders.order_line add CONSTRAINT fk_order_line_2 FOREIGN KEY (subscribed_product_id) REFERENCES cb_dev_groots.subscribed_product(subscribed_product_id)


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


ALTER TABLE base_product add COLUMN popularity SMALLINT DEFAULT 5;

alter table purchase_header add column `paid_amount` decimal(10,2) DEFAULT NULL



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

insert into groots_orders.inventory  select null,ih.id, ih.warehouse_id,ih.base_product_id, 2,0,0,0,null,1, 0, now(), now(), now() from cb_dev_groots.base_product bp join inventory_header ih on ih.base_product_id=bp.base_product_id;

ALTER TABLE groots_orders.inventory ADD UNIQUE KEY `uk_inv_1` (`inv_id`,`date`);

ALTER TABLE groots_orders.inventory_header ADD UNIQUE KEY `uk_inv_hd_1` (warehouse_id, `base_product_id`);



#alter table groots_orders.inventory_history add column transferIn decimal(10,2) DEFAULT NULL, add column transferOut decimal(10,2) DEFAULT NULL, add column order decimal(10,2) DEFAULT NULL, add column purchase decimal(10,2) DEFAULT NULL

#populate inventory one time

insert into groots_orders.inventory  select null,ih.id, ih.warehouse_id,ih.base_product_id, 2,0,0,0,null,1, 0, '2016-09-14', now(), now() from cb_dev_groots.base_product bp join inventory_header ih on ih.base_product_id=bp.base_product_id;

rename table cb_dev_groots.users to cb_dev_groots.users1;
update cb_dev_groots.users set email="admin@gogroots.com" where username='admin';

#create auth items from rbac panels
insert into users values (null, "warehouseEditor", md5("w@123"), "w@abc.com","", 0, 1, now(), now()), (null, "procurementEditor", md5("p@123"), "p@abc.com","", 0, 1, now(), now()), (null, "inventoryEditor", md5("w@123"), "i@abc.com","", 0, 1, now(), now()), (null, "transferEditor", md5("w@123"), "t@abc.com","", 0, 1, now(), now()), (null, "orderEditor", md5("w@123"), "o@abc.com","", 0, 1, now(), now()), (null, "purchaseEditor", md5("w@123"), "ps@abc.com","", 0, 1, now(), now()), (null, "orderViewer", md5("w@123"), "ov@abc.com","", 0, 1, now(), now()), (null, "inventoryViewer", md5("w@123"), "iv@abc.com","", 0, 1, now(), now());

insert into users values (null, "transferViewer", md5("w@123"), "tv@abc.com","", 0, 1, now(), now()), (null, "purchaseViewer", md5("w@123"), "pv@abc.com","", 0, 1, now(), now());
insert into profiles select id, username, username from users;

insert into AuthAssignment(itemname, userid) values ('WarehouseEditor', 10), ('ProcurementEditor', 11), ('InventoryEditor', 12), ('OrderEditor',14), ('TransferEditor', 13), ('PurchaseEditor', 15), ('InventoryViewer', 17), ('OrderViewer', 16) ;

insert into AuthAssignment(itemname, userid, bizrule) values ('TransferViewer', 18, "return $params['warehouse_id']==1;"), ('PurchaseViewer', 19, "return $params['warehouse_id']==1;") ;

update AuthAssignment set bizrule="return $params['warehouse_id']==1;" where userid in (10,12,13,14,15,16,17);

insert into profiles select id,username, username from users where id>1;
