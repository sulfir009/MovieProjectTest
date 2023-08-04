-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: movies
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `release_year` year DEFAULT NULL,
  `format` enum('VHS','DVD','Blu-Ray') DEFAULT NULL,
  `stars` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (19,'Raiders of the Lost Ark',1981,'DVD','Harrison Ford, Karen Allen'),(20,'Serenity',2005,'Blu-Ray','Nathan Fillion, Alan Tudyk, Adam Baldwin, Ron Glass, Jewel Staite, Gina Torres, Morena Baccarin, Sean Maher, Summer Glau, Chiwetel Ejiofor'),(66,'Blazing Saddles',1974,'VHS','Mel Brooks, Clevon Little, Harvey Korman, Gene Wilder, Slim Pickens, Madeline Kahn'),(67,'Casablanca',1942,'DVD','Humphrey Bogart, Ingrid Bergman, Claude Rains, Peter Lorre'),(68,'Charade',1953,'DVD','Audrey Hepburn, Cary Grant, Walter Matthau, James Coburn, George Kennedy'),(69,'Cool Hand Luke',1967,'VHS','Paul Newman, George Kennedy, Strother Martin'),(70,'Butch Cassidy and the Sundance Kid',1969,'VHS','Paul Newman, Robert Redford, Katherine Ross'),(71,'The Sting',1973,'DVD','Robert Redford, Paul Newman, Robert Shaw, Charles Durning'),(72,'The Muppet Movie',1979,'DVD','Jim Henson, Frank Oz, Dave Geolz, Mel Brooks, James Coburn, Charles Durning, Austin Pendleton'),(73,'Get Shorty ',1995,'DVD','John Travolta, Danny DeVito, Renne Russo, Gene Hackman, Dennis Farina'),(74,'My Cousin Vinny',1992,'DVD','Joe Pesci, Marrisa Tomei, Fred Gwynne, Austin Pendleton, Lane Smith, Ralph Macchio'),(75,'Gladiator',2000,'Blu-Ray','Russell Crowe, Joaquin Phoenix, Connie Nielson'),(76,'Star Wars',1977,'Blu-Ray','Harrison Ford, Mark Hamill, Carrie Fisher, Alec Guinness, James Earl Jones'),(77,'Raiders of the Lost Ark',1981,'DVD','Harrison Ford, Karen Allen'),(78,'Serenity',2005,'Blu-Ray','Nathan Fillion, Alan Tudyk, Adam Baldwin, Ron Glass, Jewel Staite, Gina Torres, Morena Baccarin, Sean Maher, Summer Glau, Chiwetel Ejiofor'),(79,'Hooisers',1986,'VHS','Gene Hackman, Barbara Hershey, Dennis Hopper'),(80,'WarGames',1983,'VHS','Matthew Broderick, Ally Sheedy, Dabney Coleman, John Wood, Barry Corbin'),(81,'Spaceballs',1987,'DVD','Bill Pullman, John Candy, Mel Brooks, Rick Moranis, Daphne Zuniga, Joan Rivers'),(82,'Young Frankenstein',1974,'VHS','Gene Wilder, Kenneth Mars, Terri Garr, Gene Hackman, Peter Boyle'),(83,'Real Genius',1985,'VHS','Val Kilmer, Gabe Jarret, Michelle Meyrink, William Atherton'),(84,'Top Gun',1986,'DVD','Tom Cruise, Kelly McGillis, Val Kilmer, Anthony Edwards, Tom Skerritt'),(85,'MASH',1970,'DVD','Donald Sutherland, Elliot Gould, Tom Skerritt, Sally Kellerman, Robert Duvall'),(86,'The Russians Are Coming, The Russians Are Coming',1966,'VHS','Carl Reiner, Eva Marie Saint, Alan Arkin, Brian Keith'),(87,'Jaws',1975,'DVD','Roy Scheider, Robert Shaw, Richard Dreyfuss, Lorraine Gary '),(88,'2001: A Space Odyssey',1968,'DVD','Keir Dullea, Gary Lockwood, William Sylvester, Douglas Rain'),(89,'Harvey',1950,'DVD','James Stewart, Josephine Hull, Peggy Dow, Charles Drake'),(90,'Knocked Up',2007,'Blu-Ray','Seth Rogen, Katherine Heigl, Paul Rudd, Leslie Mann');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-04  5:43:10
