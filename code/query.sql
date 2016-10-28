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


alter table cb_dev_groots.base_product ADD COLUMN pack_size_in_gm float DEFAULT 0 AFTER pack_unit;
update  cb_dev_groots.base_product set pack_size_in_gm=pack_size where pack_unit='gm';
update  cb_dev_groots.base_product set pack_size_in_gm=pack_size where pack_unit='g';
update  cb_dev_groots.base_product set pack_size_in_gm=pack_size*1000 where pack_unit='kg';
update  cb_dev_groots.base_product set pack_size_in_gm=pack_size*1000 where pack_unit='dozen';

update cb_dev_groots.store set store_name="GROOTS FOODS VENTURES PRIVATE LIMITED" where store_id=1;



alter table cb_dev_groots.retailer add column collection_fulfilled boolean not null default false;

CREATE TABLE cb_dev_groots.collection_agent(
id int(11) NOT NULL ,
name varchar(255) NOT NULL,
PRIMARY KEY( id )
);


alter table cb_dev_groots.retailer add column collection_frequency enum('daily', 'weekly', 'fortnight', 'monthly', '45-days') default 'daily',
 add column due_date date default null ;



update cb_dev_groots.retailer set collection_frequency = 'monthly' where id in ('136');
update cb_dev_groots.retailer set collection_frequency = 'weekly' where id in ('108','117','121','122','123','126','127','131','133','134','137','139','149','151','156','179');
update cb_dev_groots.retailer set collection_frequency = 'fortnight' where id in ('99','101','135','138','140','152');


update cb_dev_groots.retailer set due_date = '2016-10-16' where collection_frequency = 'fortnight';
update cb_dev_groots.retailer set due_date = '2016-11-01' where collection_frequency = 'monthly';
update cb_dev_groots.retailer set due_date = '2016-10-10' where collection_frequency = 'weekly';
update cb_dev_groots.retailer set due_date = '2016-10-05' where collection_frequency = 'daily';


insert into cb_dev_groots.collection_agent values (1,'Trilok');
insert into cb_dev_groots.collection_agent values (2,'Ranveer');


alter table cb_dev_groots.retailer add column last_due_date date default null;
update cb_dev_groots.retailer set last_due_date = '2016-10-01' where collection_frequency = 'fortnight';
update cb_dev_groots.retailer set last_due_date = '2016-10-01' where collection_frequency = 'monthly';
update cb_dev_groots.retailer set last_due_date = '2016-10-03' where collection_frequency = 'weekly';
update cb_dev_groots.retailer set last_due_date = '2016-10-04' where collection_frequency = 'daily';




alter table cb_dev_groots.retailer add column last_due_payment decimal(10,2) DEFAULT null;
update cb_dev_groots.retailer set last_due_payment = total_payable_amount;
---------------------------------------------------------
alter table cb_dev_groots.retailer add column collection_agent_id int(11) DEFAULT null;
update cb_dev_groots.retailer set collection_agent_id = 1 where id in ('67','69','100','112','144','147','154','158','159','161','164','166','168','169','170','175','182','183','185','186','72','101','108','109','117','123','126','131','132','133','134','135','139','140','148','149','152','179');
update cb_dev_groots.retailer set collection_agent_id = 2 where id in ('114','124','129','130','141','142','143','145','146','150','153','155','157','162','163','165','167','171','172','173','174','180','184','68','99','102','121','122','127','136','138','148','156');

alter table cb_dev_groots.collection_agent add column warehouse_id int(11) not null;


alter table cb_dev_groots.retailer change last_due_payment due_payable_amount decimal(10,2) not null;
alter table cb_dev_groots.retailer modify due_payable_amount decimal(10,2) default 0;
alter table cb_dev_groots.retailer modify collection_agent_id int(11) not null default 0;
alter table cb_dev_groots.collection_agent add column status boolean not null default 1;
---------------------------------------------------------------------------------


update cb_dev_groots.warehouses set name = 'Basai, ggn' where id = 1;

alter table cb_dev_groots.retailer add column collection_center_id int(11) not null default 0;

insert into cb_dev_groots.warehouses values(3,'Head-Office',NULL,'Ghitorni','Delhi','Delhi','Delhi','110030',NULL,NULL,NULL,'1',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL);
update cb_dev_groots.retailer set collection_center_id = 1;
update cb_dev_groots.retailer set collection_center_id = 3 where collection_frequency in ('monthly', 'fortnight');  
------------------------------------------------------------------------------------------
CREATE TABLE groots_orders.`order_header_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `payment_method` enum('cod','paytm','tpsl','prepay','tbd','paas','pay later','pay \r\n\r\nnow','operator billing','payu') DEFAULT NULL,
  `payment_status` enum('pending','paid','cod','partial_paid','success','failed','duplicate') DEFAULT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(15) DEFAULT NULL,
  `billing_email` varchar(256) DEFAULT NULL,
  `billing_address` text,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_pincode` varchar(11) DEFAULT NULL,
  `shipping_name` varchar(256) DEFAULT NULL,
  `shipping_phone` varchar(15) DEFAULT NULL,
  `shipping_email` varchar(256) DEFAULT NULL,
  `shipping_address` text,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_pincode` varchar(11) DEFAULT NULL,
  `shipping_charges` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `total_payable_amount` decimal(10,2) DEFAULT NULL,
  `total_paid_amount` decimal(10,2) DEFAULT NULL,
  `discount_amt` decimal(10,2) DEFAULT NULL,
  `coupon_code` varchar(20) DEFAULT NULL,
  `payment_ref_id` varchar(30) DEFAULT NULL,
  `payment_gateway_name` varchar(100) DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `payment_source` varchar(15) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` varchar(50) DEFAULT NULL,
  `bank_transaction_id` varchar(50) DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `payment_mod` varchar(50) DEFAULT NULL,
  `bankname` varchar(50) DEFAULT NULL,
  `status` enum('Pending','completed','failed','Out for Delivery','readytoship','shipped','returned','fulfillable','ReturnedRequested','ReturnedComplete','Confirmed','Processing','Cancelled','Packaging','Delivered','Paid') DEFAULT 'Pending',
  `delivery_date` datetime NOT NULL,
  `user_comment` text,
  `order_type` varchar(150) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `agent_name` varchar(155) DEFAULT NULL,
  `billing_address_id` int(10) DEFAULT NULL,
  `shipping_address_id` int(10) DEFAULT NULL,
  `warehouse_id` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ohl_order_1` (`order_id`),
  KEY `ohl_order_2` (`user_id`),
  KEY `ohl_order_3` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1468 DEFAULT CHARSET=latin1;

alter table groots_orders.order_header_log add column created_at datetime  default null;
alter table groots_orders.order_header_log add column action enum('INSERT', 'UPDATE', 'DELETE') not null;

create trigger groots_orders.order_header_insert after insert on groots_orders.order_header for each row
  insert into groots_orders.order_header_log values(NULL ,NEW.order_id ,NEW.order_number ,NEW.user_id ,NEW.created_date ,NEW.payment_method ,
                                      NEW.payment_status ,NEW.billing_name ,NEW.billing_phone ,NEW.billing_email ,NEW.billing_address ,
                                      NEW.billing_state ,NEW.billing_city ,NEW.billing_pincode ,NEW.shipping_name ,NEW.shipping_phone ,
                                      NEW.shipping_email ,NEW.shipping_address ,NEW.shipping_state ,NEW.shipping_city ,NEW.shipping_pincode ,
                                      NEW.shipping_charges ,NEW.tax ,NEW.total ,NEW.total_payable_amount ,NEW.total_paid_amount ,
                                      NEW.discount_amt ,NEW.coupon_code ,NEW.payment_ref_id ,NEW.payment_gateway_name ,
                                      NEW.payment_type ,NEW.payment_source ,NEW.timestamp ,NEW.transaction_id ,NEW.bank_transaction_id ,
                                      NEW.transaction_time ,NEW.payment_mod ,NEW.bankname ,NEW.status ,NEW.delivery_date ,
                                      NEW.user_comment ,NEW.order_type ,NEW.invoice_number ,NEW.agent_name ,NEW.billing_address_id ,
                                      NEW.shipping_address_id ,NEW.warehouse_id ,NOW(), 'INSERT');


create trigger groots_orders.order_header_update after update on groots_orders.order_header for each row
  insert into groots_orders.order_header_log values(
                                     NULL ,NEW.order_id ,NEW.order_number ,NEW.user_id ,NEW.created_date ,NEW.payment_method ,
                                      NEW.payment_status ,NEW.billing_name ,NEW.billing_phone ,NEW.billing_email ,NEW.billing_address ,
                                      NEW.billing_state ,NEW.billing_city ,NEW.billing_pincode ,NEW.shipping_name ,NEW.shipping_phone ,
                                      NEW.shipping_email ,NEW.shipping_address ,NEW.shipping_state ,NEW.shipping_city ,NEW.shipping_pincode ,
                                      NEW.shipping_charges ,NEW.tax ,NEW.total ,NEW.total_payable_amount ,NEW.total_paid_amount ,
                                      NEW.discount_amt ,NEW.coupon_code ,NEW.payment_ref_id ,NEW.payment_gateway_name ,
                                      NEW.payment_type ,NEW.payment_source ,NEW.timestamp ,NEW.transaction_id ,NEW.bank_transaction_id ,
                                      NEW.transaction_time ,NEW.payment_mod ,NEW.bankname ,NEW.status ,NEW.delivery_date ,
                                      NEW.user_comment ,NEW.order_type ,NEW.invoice_number ,NEW.agent_name ,NEW.billing_address_id ,
                                      NEW.shipping_address_id ,NEW.warehouse_id ,NOW() ,'UPDATE');
---------------------------------------------------------------------------------------------------------------------drop old trigger then create this one
create trigger groots_orders.order_header_delete after delete on groots_orders.order_header for each row
  insert into groots_orders.order_header_log values(
                                     NULL ,OLD.order_id ,OLD.order_number ,OLD.user_id ,OLD.created_date ,OLD.payment_method ,
                                      OLD.payment_status ,OLD.billing_name ,OLD.billing_phone ,OLD.billing_email ,OLD.billing_address ,
                                      OLD.billing_state ,OLD.billing_city ,OLD.billing_pincode ,OLD.shipping_name ,OLD.shipping_phone ,
                                      OLD.shipping_email ,OLD.shipping_address ,OLD.shipping_state ,OLD.shipping_city ,OLD.shipping_pincode ,
                                      OLD.shipping_charges ,OLD.tax ,OLD.total ,OLD.total_payable_amount ,OLD.total_paid_amount ,
                                      OLD.discount_amt ,OLD.coupon_code ,OLD.payment_ref_id ,OLD.payment_gateway_name ,
                                      OLD.payment_type ,OLD.payment_source ,OLD.timestamp ,OLD.transaction_id ,OLD.bank_transaction_id ,
                                      OLD.transaction_time ,OLD.payment_mod ,OLD.bankname ,OLD.status ,OLD.delivery_date ,
                                      OLD.user_comment ,OLD.order_type ,OLD.invoice_number ,OLD.agent_name ,OLD.billing_address_id ,
                                      OLD.shipping_address_id ,OLD.warehouse_id ,NOW() ,'DELETE');


alter table groots_orders.retailer_payments modify column payment_type enum('Cash','Cheque','DemandDraft','OnlineTransfer','Debit Note') not null default 'Cash';

alter table cb_dev_groots.retailer_product_quotation_log add column date date default null;

update cb_dev_groots.retailer_product_quotation_log set date=created_at;

alter table cb_dev_groots.retailer_product_quotation_log modify column `effective_price` double DEFAULT NULL;



CREATE TABLE `retailer_payments_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retailer_payment_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `payment_type` enum('Cash','Cheque','DemandDraft','OnlineTransfer','Debit Note') NOT NULL DEFAULT 'Cash',
  `cheque_no` varchar(256) DEFAULT NULL,
  `comment` text,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` smallint(4) NOT NULL DEFAULT '1',
  `action` enum('INSERT', 'UPDATE', 'DELETE') not null,
  PRIMARY KEY (`id`),
  KEY `fk_rt_pm_log1` (`retailer_id`),
  CONSTRAINT `fk_rt_pm_log1` FOREIGN KEY (`retailer_id`) REFERENCES `cb_dev_groots`.`retailer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=851 DEFAULT CHARSET=utf8;


create trigger groots_orders.retailer_payments_insert after insert on groots_orders.retailer_payments for each row 
  insert into groots_orders.retailer_payments_log values(
                                                    NULL ,NEW.id ,NEW.retailer_id ,
                                                    NEW.paid_amount ,NEW.date ,NEW.payment_type ,NEW.cheque_no ,
                                                    NEW.comment ,NEW.created_at ,NEW.updated_at ,NEW.status,'INSERT');

create trigger groots_orders.retailer_payments_update after update on groots_orders.retailer_payments for each row 
  insert into groots_orders.retailer_payments_log values(
                                                    NULL ,NEW.id ,NEW.retailer_id ,
                                                    NEW.paid_amount ,NEW.date ,NEW.payment_type ,NEW.cheque_no ,
                                                    NEW.comment ,NEW.created_at ,NEW.updated_at ,NEW.status,'UPDATE');

create trigger groots_orders.retailer_payments_delete after delete on groots_orders.retailer_payments for each row 
  insert into groots_orders.retailer_payments_log values(
                                                    NULL ,OLD.id ,OLD.retailer_id ,
                                                    OLD.paid_amount ,OLD.date ,OLD.payment_type ,OLD.cheque_no ,
                                                    OLD.comment ,OLD.created_at ,OLD.updated_at ,OLD.status,'DELETE');


CREATE TABLE `retailer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` enum('INSERT', 'UPDATE', 'DELETE') not null,
  `retailer_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `retailer_code` varchar(10) DEFAULT NULL,
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
  `billing_email` varchar(255) DEFAULT NULL,
  `settlement_days` varchar(255) DEFAULT NULL,
  `time_of_delivery` varchar(255) DEFAULT NULL,
  `demand_centre` varchar(255) DEFAULT NULL,
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
  `collecttion_agent` varchar(155) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime DEFAULT NULL,
  `min_order_price` float DEFAULT NULL,
  `shipping_charge` float DEFAULT NULL,
  `allocated_warehouse_id` int(11) unsigned NOT NULL DEFAULT '1',
  `initial_payable_amount` decimal(10,2) DEFAULT NULL,
  `total_payable_amount` decimal(10,2) DEFAULT NULL,
  `collection_fulfilled` tinyint(1) NOT NULL DEFAULT '0',
  `collection_frequency` enum('daily','weekly','fortnight','monthly','45-days') DEFAULT 'daily',
  `due_date` date DEFAULT NULL,
  `last_due_date` date DEFAULT NULL,
  `due_payable_amount` decimal(10,2) DEFAULT '0.00',
  `collection_agent_id` int(11) NOT NULL DEFAULT '0',
  `collection_center_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_retailer_log1` (`allocated_warehouse_id`),
  CONSTRAINT `fk_retailer_log1` FOREIGN KEY (`allocated_warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=latin1;


create trigger cb_dev_groots.retailer_log_insert after insert on cb_dev_groots.retailer for each row
  insert into cb_dev_groots.retailer_log values(NULL ,'INSERT' ,NEW.id ,NEW.name ,NEW.retailer_code ,
                                          NEW.VAT_number ,NEW.email ,NEW.password ,NEW.mobile ,NEW.telephone ,NEW.address ,NEW.pincode ,NEW.geolocation ,
                                          NEW.owner_phone ,NEW.owner_email ,NEW.billing_email ,NEW.settlement_days ,NEW.time_of_delivery ,NEW.demand_centre
                                           ,NEW.date_of_onboarding ,NEW.city ,NEW.state ,NEW.image ,NEW.image_url ,NEW.website ,NEW.contact_person1 ,
                                           NEW.contact_person2 ,NEW.product_categories ,NEW.categories_of_interest ,NEW.store_size ,NEW.status ,NEW.credit_limit ,
                                           NEW.collecttion_agent ,NEW.created_date ,NEW.modified_date ,NEW.min_order_price ,NEW.shipping_charge ,
                                           NEW.allocated_warehouse_id ,NEW.initial_payable_amount ,NEW.total_payable_amount ,NEW.collection_fulfilled ,
                                          NEW.collection_frequency ,NEW.due_date ,NEW.last_due_date ,NEW.due_payable_amount ,NEW.collection_agent_id ,
                                          NEW.collection_center_id);

create trigger cb_dev_groots.retailer_log_update after update on cb_dev_groots.retailer for each row
  insert into cb_dev_groots.retailer_log values(NULL ,'UPDATE' ,NEW.id ,NEW.name ,NEW.retailer_code ,
                                          NEW.VAT_number ,NEW.email ,NEW.password ,NEW.mobile ,NEW.telephone ,NEW.address ,NEW.pincode ,NEW.geolocation ,
                                          NEW.owner_phone ,NEW.owner_email ,NEW.billing_email ,NEW.settlement_days ,NEW.time_of_delivery ,NEW.demand_centre
                                           ,NEW.date_of_onboarding ,NEW.city ,NEW.state ,NEW.image ,NEW.image_url ,NEW.website ,NEW.contact_person1 ,
                                           NEW.contact_person2 ,NEW.product_categories ,NEW.categories_of_interest ,NEW.store_size ,NEW.status ,NEW.credit_limit ,
                                           NEW.collecttion_agent ,NEW.created_date ,NEW.modified_date ,NEW.min_order_price ,NEW.shipping_charge ,
                                           NEW.allocated_warehouse_id ,NEW.initial_payable_amount ,NEW.total_payable_amount ,NEW.collection_fulfilled ,
                                          NEW.collection_frequency ,NEW.due_date ,NEW.last_due_date ,NEW.due_payable_amount ,NEW.collection_agent_id ,
                                          NEW.collection_center_id);

create trigger cb_dev_groots.retailer_log_delete after delete on cb_dev_groots.retailer for each row
  insert into cb_dev_groots.retailer_log values(NULL ,'DELETE' ,OLD.id ,OLD.name ,OLD.retailer_code ,
                                          OLD.VAT_number ,OLD.email ,OLD.password ,OLD.mobile ,OLD.telephone ,OLD.address ,OLD.pincode ,OLD.geolocation ,
                                          OLD.owner_phone ,OLD.owner_email ,OLD.billing_email ,OLD.settlement_days ,OLD.time_of_delivery ,OLD.demand_centre
                                           ,OLD.date_of_onboarding ,OLD.city ,OLD.state ,OLD.image ,OLD.image_url ,OLD.website ,OLD.contact_person1 ,
                                           OLD.contact_person2 ,OLD.product_categories ,OLD.categories_of_interest ,OLD.store_size ,OLD.status ,OLD.credit_limit ,
                                           OLD.collecttion_agent ,OLD.created_date ,OLD.modified_date ,OLD.min_order_price ,OLD.shipping_charge ,
                                           OLD.allocated_warehouse_id ,OLD.initial_payable_amount ,OLD.total_payable_amount ,OLD.collection_fulfilled ,
                                          OLD.collection_frequency ,OLD.due_date ,OLD.last_due_date ,OLD.due_payable_amount ,OLD.collection_agent_id ,
                                          OLD.collection_center_id);

