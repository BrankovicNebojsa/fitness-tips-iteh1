/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.25-MariaDB : Database - workout_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`workout_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `workout_db`;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`email`) values 
(1,'admin','admin','admin@gmail.com'),
(16,'nebojsa','nebojsa','brankovic.n99@gmail.com');

/*Table structure for table `workout` */

DROP TABLE IF EXISTS `workout`;

CREATE TABLE `workout` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exercise_time` int(11) NOT NULL,
  `difficulty_level` int(11) NOT NULL,
  `first_exercise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `second_exercise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `third_exercise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`user_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `workout` */

insert  into `workout`(`id`,`name`,`exercise_time`,`difficulty_level`,`first_exercise`,`second_exercise`,`third_exercise`,`description`,`image`,`user_id`) values 
(1,'Arnold\'s Chest Workout',55,4,'Barbell bench press: 5 sets of 8-12','Barbell incline press: 5 sets of 8-12','Pullover: 5 sets of 8-12','During the first few months of your training, Arnold recommends that you stick with just three movements for your chest: the bench press, the incline press, and the pullover.','chest-day.jpg',1),
(2,'Chris Bumstead\'s Arms Day',30,6,'Barbell Bicep Curl: 3 sets of 8-12','Dumbbell Preacher Curl: 3 sets of 8-12','Cable Bicep Curl: 3 sets of 10-15','If you\'re here looking for the best arm exercises for your next gym session, you\'ve come to the right place.','arms-day.jpg',1),
(12,'Shoulder Workout',45,5,'Dumbell Front Raise: 3 sets of 10-15','Dumbell Lateral Raise: 3 sets of 10-15','Reverse Fly: 3 sets of 8-12','Shoulder strength training can reduce your risk of injury by strengthening your core muscles, which makes you more stable and lessens imbalances.','shoulder-day.jpg',1),
(14,'Killer Abs Workout',20,3,'V-Ups: 3 sets of 20','Hollow Holds: 3 sets of 15','Heel Tap Crunches: 3 sets of 20','It’s safe to say then that ab exercises deserve as much time and attention as any muscle group in your body. That said, it’s important that you’re not just putting in work, but that you’re also working intelligently, which is why we’ve collated the best ab exercises and ab workouts to get your mid-section firing.','ab-day.jpg',1),
(24,'Breakthrough Calves Workout',35,4,'Standing calf raises: 3 sets of 8-12','Seated calf raises: 4 sets of 10-15','Jump rope: 3 sets of 1 minute','Well-developed, strong calves are one of the key components to a balanced lower body. However, the calves tend to be known as one of the more challenging muscle groups for many people to build and grow. Unless genetically blessed with developed calf muscles, most clients must work to build them.','calves-day.jpg',1),
(30,'Ronnie Coleman\'s Back Workout',60,8,'Deadlift: 4 sets of 8-12','Barbell Rows: 3 sets of 10-12','T-Bar Rows: 3 sets of 10-15','The moments just before Ronnie Coleman hit his rear lat spread and rear double biceps were contest highlights, as ridges and knots roamed and stripes and crevices emerged, morphing his back into a new and spectacular landscape each time he moved his arms. At his best, his back was like a great symphony orchestra, big and booming, sometimes overwhelming, and yet each finely tuned part played its role precisely.','back-day.jpg',1),
(31,'Brutal Leg Workout',75,7,'Barbell Squats: 3 sets of 8-12','Leg Press: 4 sets of 6-8','Hack Squats: 3 sets of 10-15','Hitting legs is, without a doubt, one of the most intensive body parts to train. This is because the legs are a large muscle group that requires a lot of energy and attention.','leg-day.jpg',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
