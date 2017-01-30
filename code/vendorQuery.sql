alter table groots_orders.purchase_header drop foreign key fk_purchase_hd_2;
alter table groots_orders.purchase_header drop column vendor_id ;


----------------------------------------------------------------vendor table edit
alter table cb_dev_groots.vendors drop column geolocation, drop product_categories, drop categories_of_interest, drop store_size, drop min_order_price, drop shipping_charge;

alter table cb_dev_groots.vendors
    add column `bussiness_name` varchar(255) default null,
    add column `payment_terms` int(3) default null;


alter table cb_dev_groots.vendors add column proc_exec_id int(11) not null;

alter table cb_dev_groots.vendors add column vendor_type enum('Auctioneer', 'Trader', 'Reseller') not null; 


CREATE TABLE groots_orders.vendor_payments (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `payment_type` enum('Cash','Cheque','DemandDraft','NetBanking','Debit Note') NOT NULL DEFAULT 'Cash',
  `cheque_no` varchar(256) DEFAULT NULL,
  `debit_no` varchar(256) DEFAULT NULL,
  `cheque_status` enum('Pending' , 'Bounced', 'Cleared') NOT NULL DEFAULT 'Pending',
  `cheque_issue_date` date default null,
  `cheque_name` varchar(255) default null,
  `transaction_id` varchar(25) default null,
  `receiving_acc_no` varchar(25) default null,
  `bank_name` varchar(300) default null,
  `isfc_code` varchar(15) default null,
  `acc_holder_name` varchar(300) default null,
  `comment` text,
  `created_at` date NOT NULL,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` smallint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_vd_pm_1` (`vendor_id`),
  CONSTRAINT `fk_vd_pm_1` FOREIGN KEY (`vendor_id`) REFERENCES `cb_dev_groots`.`vendors` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



alter table cb_dev_groots.vendors add column credit_days int(3) default null;
alter table cb_dev_groots.vendors add column due_date date default null;

alter table cb_dev_groots.vendors add column payment_days_range int(3) not null;
alter table cb_dev_groots.vendors change payment_terms payment_start_date date not null;


alter table cb_dev_groots.vendors modify column updated_at timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP;




alter table purchase_line add column vendor_id int (11) not null;
update purchase_line as pl left join purchase_header as ph on ph.id = pl.purchase_id set pl.vendor_id = ph.vendor_id; 


create table cb_dev_groots.vendor_log(
  id int(11) not null AUTO_INCREMENT,
  vendor_id int(11) not null,
  total_pending decimal(10,2) not null default '0.00',
  base_date date not null,
  created_at datetime not null,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  primary key (id),
  key fk_vl_1 (vendor_id),
  constraint fk_vl_1 foreign key (vendor_id) REFERENCES cb_dev_groots.vendors (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 default CHARSET=utf8;

insert into vendor_log values (null, 1, 3743.90, "2016-12-01", CURDATE(), null);

alter table vendors add column initial_pending_date date not null;
update vendors set initial_pending_date = "2016-12-01";


create table vendor_product_mapping(
id int(11) not null AUTO_INCREMENT,
vendor_id int(11) not null,
base_product_id int(11) unsigned not null,
price int(11) unsigned NOT NULL,
status tinyint(1) not null default 1,
created_at date not null,
updated_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
updated_by int(11) not null,
primary key (id),
key fk_vpm_1 (vendor_id),
constraint fk_vpm_1 foreign key (vendor_id) REFERENCES cb_dev_groots.vendors (id),
key fk_vpm_2 (base_product_id),
constraint fk_vpm_2 foreign key (base_product_id) REFERENCES cb_dev_groots.base_product (base_product_id)
)ENGINE=InnoDB AUTO_INCREMENT=1 default CHARSET=utf8;


insert into groots_employee values(null, 'Kamlesh', null, null, null, null, null, CURDATE(), 1,1,1,CURDATE(),null,   1);
insert into employee_department values(null, 5, 2, CURDATE(), null, 1);

insert into cb_dev_groots.users values (null, "VendorEditor", md5("ve@123"), "ve@abc.com","", 0, 1, now(), now()), 
  (null, "VendorCreditEditor", md5("vce@123"), "vce@abc.com","", 0, 1, now(), now()), 
  (null, "VendorProductEditor", md5("vpe@123"), "vpe@abc.com","", 0, 1, now(), now()), 
  (null, "VendorProfileEditor", md5("vpr@123"), "vpr@abc.com","", 0, 1, now(), now()), 
  (null, "VendorLedgerEditor", md5("vle@123"), "vle@abc.com","", 0, 1, now(), now()), 
  (null, "VendorCreditViewer", md5("vcp@123"), "vcp@abc.com","", 0, 1, now(), now()), 
  (null, "VendorProductViewer", md5("vpv@123"), "vpv@abc.com","", 0, 1, now(), now()),
   (null, "VendorLedgerViewer", md5("vlv@123"), "vlv@abc.com","", 0, 1, now(), now()), 
   (null, "VendorProfileViewer", md5("vprv@123"), "vprv@abc.com","", 0, 1, now(), now());

insert into cb_dev_groots.AuthAssignment(itemname, userid, bizrule) values
 ('VendorEditor', 24, "return $params['warehouse_id']==1;"),
 ('VendorCreditEditor', 25, "return $params['warehouse_id']==1;"), 
 ('VendorProductEditor', 26, "return $params['warehouse_id']==1;"), 
 ('VendorProfileEditor', 27, "return $params['warehouse_id']==1;"),
 ('VendorLedgerEditor',28, "return $params['warehouse_id']==1;"),  
 ('VendorCreditViewer', 29,"return $params['warehouse_id']==1;"),
 ('VendorProductViewer', 30,"return $params['warehouse_id']==1;") , 
 ('VendorLedgerViewer', 31,"return $params['warehouse_id']==1;"), 
 ('VendorProfileViewer', 32, "return $params['warehouse_id']==1;");



update groots_orders.purchase_line as l join base_product as b on b.base_product_id = l.base_product_id set l.pack_unit = b.pack_unit, l.pack_size = b.pack_size;

alter table groots_orders.purchase_header drop foreign key fk_purchase_hd_2;

alter table groots_orders.purchase_header drop column vendor_id ;


alter table cb_dev_groots.vendors add column supplier_type enum('Vegetables','Fruits') default 'Vegetables';
alter table groots_orders.purchase_line add column urd_number int(11) not null;

