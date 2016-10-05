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
-------------------------------------------------------------
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

--------------------------------------------------------------------
insert into cb_dev_groots.collection_agent('1','Trilok');
insert into cb_dev_groots.collection_agent('2','Ranveer');

-----------------------------------------------------------------------
alter table cb_dev_groots.retailer add column last_due_date date default null;
update cb_dev_groots.retailer set last_due_date = '2016-10-01' where collection_frequency = 'fortnight';
update cb_dev_groots.retailer set last_due_date = '2016-10-01' where collection_frequency = 'monthly';
update cb_dev_groots.retailer set last_due_date = '2016-10-03' where collection_frequency = 'weekly';
update cb_dev_groots.retailer set last_due_date = '2016-10-04' where collection_frequency = 'daily';


select rep2.retailer_id, rep2.date , sum(paid_amount) 
from groots_orders.retailer_payments as rep2 
inner join (select retailer_id, max(date) as date 
            from groots_orders.retailer_payments group by retailer_id
            ) as rep1
on(rep2.retailer_id = rep1.retailer_id and rep2.date = rep1.date)
group by rep2.retailer_id, rep2.date;