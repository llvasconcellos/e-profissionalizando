INSERT INTO `tblconfiguration` (`setting` ,`value` )VALUES ('SEOFriendlyUrls', '');
INSERT INTO `tblconfiguration` (`setting` ,`value` )VALUES ('ShowCCIssueStart', '');

ALTER TABLE `tblcustomfields` CHANGE `relid` `relid` INT( 10 ) NOT NULL DEFAULT '0' ;
ALTER TABLE `tblcustomfields` ADD `sortorder` INT( 10 ) NOT NULL DEFAULT '0';

ALTER TABLE `tblproductconfigoptionssub` ADD `sortorder` INT( 10 ) NOT NULL DEFAULT '0';

ALTER TABLE `tbladdons` ADD `tax` TEXT NOT NULL AFTER `billingcycle` ;
UPDATE tbladdons SET tax='on';
ALTER TABLE `tblhostingaddons` ADD `tax` TEXT NOT NULL AFTER `billingcycle` ;
UPDATE tblhostingaddons SET tax='on';

INSERT INTO `tblconfiguration` (`setting`, `value`) VALUES ('ClientDropdownFormat', '1');

INSERT INTO `tblconfiguration` (`setting` ,`value` )VALUES ('TicketRatingEnabled', 'on');
ALTER TABLE `tblticketreplies` ADD `rating` INT( 5 ) NOT NULL ;

CREATE TABLE `tblproductconfiggroups` (
  `id` int(10) NOT NULL auto_increment,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `tblproductconfiglinks` (
  `gid` int(10) NOT NULL,
  `pid` int(10) NOT NULL
);

ALTER TABLE `tblproductconfigoptions` CHANGE `productid` `gid` INT( 10 ) NOT NULL DEFAULT '0' ;

CREATE TABLE `tblnetworkissues` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `type` enum('Server','System','Other') NOT NULL,
  `affecting` varchar(100) default NULL,
  `server` int(10) unsigned default NULL,
  `priority` enum('Critical','Low','Medium','High') NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime default NULL,
  `status` enum('Reported','Investigating','In Progress','Outage','Scheduled','Resolved') NOT NULL,
  `lastupdate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);
INSERT INTO `tblconfiguration` (`setting`, `value`) VALUES ('NetworkIssuesRequireLogin', 'on');

INSERT INTO `tblconfiguration` (`setting` ,`value` )VALUES ('ShowNotesFieldonCheckout', 'on');
ALTER TABLE `tblorders` ADD `notes` TEXT NOT NULL ;

INSERT INTO `tblconfiguration` (`setting` ,`value` )VALUES ('RequireLoginforClientTickets', 'on');

ALTER TABLE `tblhostingaddons` CHANGE `subscriptionid` `notes` TEXT NOT NULL ;

CREATE TABLE `tblquotes` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`subject` TEXT NOT NULL ,
`stage` ENUM( 'Draft', 'Delivered', 'On Hold', 'Accepted', 'Lost', 'Dead' ) NOT NULL ,
`validuntil` DATE NOT NULL ,
`userid` INT( 10 ) NOT NULL ,
`firstname` TEXT NOT NULL ,
`lastname` TEXT NOT NULL ,
`companyname` TEXT NOT NULL ,
`email` TEXT NOT NULL ,
`address1` TEXT NOT NULL ,
`address2` TEXT NOT NULL ,
`city` TEXT NOT NULL ,
`state` TEXT NOT NULL ,
`postcode` TEXT NOT NULL ,
`country` TEXT NOT NULL ,
`phonenumber` TEXT NOT NULL ,
`subtotal` DECIMAL( 10, 2 ) NOT NULL ,
`tax1` DECIMAL( 10, 2 ) NOT NULL ,
`tax2` DECIMAL( 10, 2 ) NOT NULL ,
`total` DECIMAL( 10, 2 ) NOT NULL ,
`customernotes` TEXT NOT NULL ,
`adminnotes` TEXT NOT NULL ,
`datecreated` DATE NOT NULL ,
`lastmodified` DATE NOT NULL
);

CREATE TABLE `tblquoteitems` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`quoteid` INT( 10 ) NOT NULL ,
`description` TEXT NOT NULL ,
`quantity` TEXT NOT NULL ,
`unitprice` DECIMAL( 10, 2 ) NOT NULL ,
`discount` DECIMAL( 10, 2 ) NOT NULL ,
`taxable` INT( 1 ) NOT NULL
);

INSERT INTO `tblemailtemplates` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`) VALUES('', 'general', 'Quote Delivery with PDF', 'Quote #{$quote_number} - {$quote_subject}', '<p>Dear {$client_name},</p>\r\n<p>Here is the quote you requested for {$quote_subject}. The quote is valid until {$quote_valid_until}. You may simply reply to this email with any furthur questions or requirement.</p>\r\n<p>{$signature}</p>', '', '', '', '', '', '', 0);

INSERT INTO `tbladminperms` (`roleid` ,`permid` ) VALUES ('1', '84'), ('1', '85'), ('2', '85');

UPDATE tblconfiguration SET value='3.8.0' WHERE setting='Version';