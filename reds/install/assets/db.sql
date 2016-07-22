/*
SQLyog Community v11.51 (32 bit)
MySQL - 5.6.25 : Database - commerce
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`commerce` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `commerce`;

/*Table structure for table `bank_account` */

DROP TABLE IF EXISTS `bank_account`;

CREATE TABLE `bank_account` (
  `bank_account_id` int(10) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(32) DEFAULT NULL,
  `bank_account` varchar(32) DEFAULT NULL,
  `bank_owner` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`bank_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bank_account` */

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `category_parent` int(10) DEFAULT NULL,
  `category_images` varchar(250) DEFAULT NULL,
  `category_url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`category_id`,`category_name`,`category_parent`,`category_images`,`category_url`) values (1,'Clothes Men',0,'http://localhost/reds/images/data/fashion-for-men.jpg','Clothes-Men-1'),(2,'Clothes Women',0,'http://localhost/reds/images/data/o-FASHION-facebook.jpg','Clothes-Women-2'),(4,'MODERN',0,'http://localhost/reds/images/data/slider6.jpg','MODERN-4'),(5,'Childs',0,'http://localhost/reds/images/data/bcphilippinesll.jpg','Childs-5');

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id_member` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `emails` varchar(150) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `address` text,
  `password` varchar(32) DEFAULT NULL,
  `dates_entry` datetime DEFAULT NULL,
  `member_themes` varchar(255) DEFAULT 'afro',
  PRIMARY KEY (`id_member`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `member` */

insert  into `member`(`id_member`,`name`,`emails`,`phone`,`address`,`password`,`dates_entry`,`member_themes`) values (1,'antonius Doni','admin@gmail.com','08789364667','Jalan wates|Bantul|DI Yogyakarta|Indonesia','admin',NULL,'afro'),(2,'Antonius Doni O','info@afroskincosmetics.com','08789364667','Jalan Adi Sucipto|Denpasar|Bali|Indonesia','admin',NULL,'afro');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `idmenu` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `typepost` int(10) DEFAULT NULL,
  `parent` int(10) DEFAULT '0',
  `url` varchar(250) DEFAULT NULL,
  `positionmenu` int(10) DEFAULT '0',
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`idmenu`,`title`,`typepost`,`parent`,`url`,`positionmenu`) values (4,'Home',0,0,'http://localhost/myweb/',1),(5,'About Us',1,0,'http://localhost/reds/detailpost/About-Us',2),(11,'Contact Us',5,0,'http://localhost/reds/contactus',5),(15,'Our Product',7,0,'http://localhost/reds/product_all/Our Product',4),(16,'Category',4,0,'http://localhost/reds/categorytall/Category',3);

/*Table structure for table `order_detail` */

DROP TABLE IF EXISTS `order_detail`;

CREATE TABLE `order_detail` (
  `id_order_detail` int(10) NOT NULL AUTO_INCREMENT,
  `id_order` int(10) DEFAULT NULL,
  `id_detail_product` int(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_order_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `order_detail` */

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id_order` int(10) NOT NULL AUTO_INCREMENT,
  `code_order` varchar(32) DEFAULT NULL,
  `id_member` int(10) DEFAULT NULL,
  `shipping_price` varchar(50) DEFAULT NULL,
  `shipping_type` varchar(150) DEFAULT NULL,
  `shiping_code` varchar(250) DEFAULT NULL,
  `estimate_deliver` varchar(32) DEFAULT NULL,
  `total_price` varchar(50) DEFAULT NULL,
  `name_order` varchar(255) DEFAULT NULL,
  `address_order` text,
  `phone_order` varchar(50) DEFAULT NULL,
  `status_order` enum('Pending','Pay','Shiping','Done') DEFAULT 'Pending',
  `dates_order` datetime DEFAULT NULL,
  `order_random` varchar(32) DEFAULT NULL,
  `member_bank` varchar(32) DEFAULT NULL,
  `member_account_bank` varchar(50) DEFAULT NULL,
  `transfer_date` datetime DEFAULT NULL,
  `images_bank` varchar(255) DEFAULT NULL,
  `transfer_amount` varchar(50) DEFAULT NULL,
  `note_payment` text,
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `orders` */

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id_post` int(10) NOT NULL AUTO_INCREMENT,
  `id_category` int(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `images` text,
  `metaTag` text,
  `metadescription` text,
  `post_randcode` varchar(50) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `dates_post` datetime DEFAULT NULL,
  `is_publish` tinyint(2) DEFAULT '1',
  `creat_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `post` */

insert  into `post`(`id_post`,`id_category`,`title`,`images`,`metaTag`,`metadescription`,`post_randcode`,`url`,`dates_post`,`is_publish`,`creat_id`) values (1,0,'About Us','http://localhost/reds/images/data/o-FASHION-facebook.jpg','about us','about us','ea8e41da0f2940c1788387c4e99d58f3','About-Us','2016-07-22 13:51:04',1,'admin@gmail.com');

/*Table structure for table `post_comment` */

DROP TABLE IF EXISTS `post_comment`;

CREATE TABLE `post_comment` (
  `id_post_comment` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `comment` text,
  `username` varchar(255) DEFAULT NULL,
  `emails` varchar(250) DEFAULT NULL,
  `input_date` datetime DEFAULT NULL,
  `id_post` int(10) DEFAULT NULL,
  `id_parent_comment` int(11) DEFAULT '0',
  `is_publish` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id_post_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `post_comment` */

/*Table structure for table `post_description` */

DROP TABLE IF EXISTS `post_description`;

CREATE TABLE `post_description` (
  `id_post_description` int(10) NOT NULL AUTO_INCREMENT,
  `description` text,
  `lang` varchar(25) DEFAULT NULL,
  `id_post` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_post_description`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `post_description` */

insert  into `post_description`(`id_post_description`,`description`,`lang`,`id_post`) values (1,'','ID',1),(2,'','EN',1);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id_product` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `id_category` int(10) DEFAULT NULL,
  `main_images` varchar(255) DEFAULT NULL,
  `metaTag` text,
  `metaDescription` text,
  `product_random` varchar(50) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `images1` varchar(255) DEFAULT NULL,
  `images2` varchar(255) DEFAULT NULL,
  `images3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `product` */

insert  into `product`(`id_product`,`title`,`description`,`id_category`,`main_images`,`metaTag`,`metaDescription`,`product_random`,`url`,`images1`,`images2`,`images3`) values (1,'Childs','<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',5,'http://localhost/reds/images/data/bcphilippinesll.jpg','clothes childrens','clothes childrens','f86cd74cb50335e0be379140f7171363','Childs','http://localhost/reds/images/data/childs/c7ff2ebe6eb1ad09a22c0ab6f7e0f066.jpg','',''),(2,'Childs x2','<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',5,'http://localhost/reds/images/data/bcphilippinesll.jpg','clothes childrens','clothes childrens','b0d6f568166dbd880d6afac30dea5b07','Childs-x2','http://localhost/reds/images/data/childs/05da1b28bab4d7ca1f931fdc77573031.jpg','',''),(3,'Childs x3','<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',5,'http://localhost/reds/images/data/bcphilippinesll.jpg','clothes childrens','clothes childrens','2c3cdde59d9243ad5a783104747773d2','Childs-x3','http://localhost/reds/images/data/childs/05da1b28bab4d7ca1f931fdc77573031.jpg','',''),(4,'Modern','<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',4,'http://localhost/reds/images/data/slider6.jpg','clothes Modern','clothes Modern','d28e0c2cb4625140dd1cb3844fe60ccf','Modern','http://localhost/reds/images/data/modern/f097abfe-d3d6-42c5-9768-11616bc985e2.jpg','',''),(5,'Modern x2','<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />\r\n&nbsp;',4,'http://localhost/reds/images/data/bcphilippinesll.jpg','clothes Modern','clothes Modern','e5149f5a7af2c564281f2dfd811e915d','Modern-x2','http://localhost/reds/images/data/modern/4000.jpg','',''),(6,'Modern x3','',4,'http://localhost/reds/images/data/modern/4000.jpg','clothes Modern','clothes Modern','531c75e2da6c4eb80e6a262dcb6eaf79','Modern-x3','http://localhost/reds/images/data/modern/f097abfe-d3d6-42c5-9768-11616bc985e2.jpg','','');

/*Table structure for table `product_detail` */

DROP TABLE IF EXISTS `product_detail`;

CREATE TABLE `product_detail` (
  `id_product_detail` int(10) NOT NULL AUTO_INCREMENT,
  `size` varchar(50) DEFAULT 'all size',
  `prices` varchar(50) DEFAULT NULL,
  `stok` int(10) DEFAULT NULL,
  `id_product` int(10) DEFAULT NULL,
  `diskon` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_product_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `product_detail` */

insert  into `product_detail`(`id_product_detail`,`size`,`prices`,`stok`,`id_product`,`diskon`) values (2,'allsize','100000',5,1,'0'),(3,'allsize','120000',10,2,'0'),(4,'allsize','100000',11,3,'0'),(5,'L','100000',15,4,'0'),(6,'M','120000',10,4,'0'),(7,'XL','100000',10,4,'0'),(8,'allsize','100000',10,5,'0'),(11,'allsize','100000',3,6,'0');

/*Table structure for table `returns` */

DROP TABLE IF EXISTS `returns`;

CREATE TABLE `returns` (
  `returns_id` int(10) NOT NULL AUTO_INCREMENT,
  `code_orders` varchar(50) DEFAULT NULL,
  `note` text,
  `status` enum('Reject','Approve','Progress') DEFAULT 'Progress',
  `date_return` datetime DEFAULT NULL,
  `images_return` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`returns_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `returns` */

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `idgm` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `emails` varchar(255) DEFAULT NULL,
  `gplus` varchar(250) DEFAULT NULL,
  `fb` varchar(250) DEFAULT NULL,
  `twiter` varchar(250) DEFAULT NULL,
  `theme` varchar(150) DEFAULT 'defaults',
  `password` varchar(100) DEFAULT NULL,
  `address` text,
  `tlp` varchar(70) DEFAULT NULL,
  `isecommer` tinyint(2) DEFAULT '0',
  `versioning` tinyint(2) DEFAULT '1',
  `metaKeyword` text,
  `metaDescription` text,
  PRIMARY KEY (`idgm`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `setting` */

insert  into `setting`(`idgm`,`title`,`emails`,`gplus`,`fb`,`twiter`,`theme`,`password`,`address`,`tlp`,`isecommer`,`versioning`,`metaKeyword`,`metaDescription`) values (1,'My Web','admin@gmail.com',NULL,NULL,NULL,'defaults','admin',NULL,NULL,1,1,'Open source Code with codeigniter.,codeigniter,code,open source','Open source Code with codeigniter.,codeigniter,code,open source');

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `id_slider` int(10) NOT NULL AUTO_INCREMENT,
  `description` text,
  `images` varchar(255) DEFAULT NULL,
  `links` varchar(255) DEFAULT NULL,
  `links_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_slider`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `slider` */

insert  into `slider`(`id_slider`,`description`,`images`,`links`,`links_type`) values (1,'Clothes','http://localhost/reds/images/data/o-FASHION-facebook.jpg','#',0),(2,'Clothes','http://localhost/reds/images/data/fashion-for-men.jpg','#',0),(3,'Clothes','http://localhost/reds/images/data/slider6.jpg','#',0);

/*Table structure for table `wishlist` */

DROP TABLE IF EXISTS `wishlist`;

CREATE TABLE `wishlist` (
  `idwishlist` int(10) NOT NULL AUTO_INCREMENT,
  `idmember` int(10) DEFAULT NULL,
  `idproduct` int(10) DEFAULT NULL,
  `datewishlist` date DEFAULT NULL,
  `size` varbinary(50) DEFAULT NULL,
  PRIMARY KEY (`idwishlist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `wishlist` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
