-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2023 at 11:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajoshi7_cities`
--

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `destination_id` int(6) NOT NULL,
  `name` varchar(70) NOT NULL,
  `description` varchar(255) NOT NULL,
  `nearest_airport` varchar(70) NOT NULL,
  `best_season` varchar(70) NOT NULL,
  `population` decimal(8,2) NOT NULL COMMENT 'in millions',
  `average_time` varchar(70) NOT NULL COMMENT 'example (7D/10N)',
  `average_budget` decimal(8,2) NOT NULL COMMENT 'in thousands (k)',
  `language` varchar(70) NOT NULL,
  `altitude` decimal(10,3) NOT NULL,
  `trek_length` decimal(8,3) DEFAULT NULL COMMENT 'in kilometers (km)',
  `rating` decimal(5,2) DEFAULT NULL COMMENT 'out of 5',
  `file_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`destination_id`, `name`, `description`, `nearest_airport`, `best_season`, `population`, `average_time`, `average_budget`, `language`, `altitude`, `trek_length`, `rating`, `file_name`) VALUES
(1, 'Rishikesh', 'A spiritual destination known for yoga and adventure sports.', 'Dehradun Airport', 'Spring', 0.10, '3D/4N', 10.00, 'Hindi/English', 372.000, 0.000, 4.90, 'pexels-photo-15196909.jpeg'),
(7, 'Nainital', 'Popular hill station known for its picturesque Naini Lake.', 'Pantnagar Airport', 'Fall', 0.41, '4D/5N', 20.00, 'English/Hindi/Kumaoni', 2084.000, 0.000, 4.70, 'pexels-photo-16060830.jpeg'),
(10, 'Auli', 'Famous ski destination with mesmerizing views of the Himalayas.', 'Dehradun Airport', 'Winter', 0.10, '4D/5N', 30.00, 'English/Hindi/Garhwali', 2800.000, 1.000, 4.80, 'pexels-photo-8206039.jpeg'),
(14, 'Haridwar', 'Haridwar is an ancient city and an important Hindu pilgrimage site, located in the foothills of the Himalayas.', 'Dehradun Airport', 'All Weather', 0.23, '2D/1N', 5.00, 'English/Hindi', 314.600, 0.000, 4.60, 'pexels-photo-10783023.jpeg'),
(15, 'Valley of Flowers', 'A UNESCO World Heritage site with stunning landscapes.', 'Dehradun Airport', 'Fall', 0.01, '6D/7N', 25.00, 'Hindi/Garhwali', 3658.000, 20.000, 4.80, 'pexels-photo-554609.jpeg'),
(16, 'Chopta', 'A picturesque hamlet known as the Mini Switzerland of India.', 'Dehradun Airport', 'Spring', 0.01, '4D/5N', 30.00, 'English/Hindi/Garhwali', 2700.000, 10.000, 4.60, 'pexels-photo-7846473.jpeg'),
(17, 'Kedarnath', 'Sacred Hindu shrine and a part of the Char Dham Yatra.', 'Dehradun Airport', 'Summer', 0.01, '3D/4N', 30.00, 'English/Hindi/Garhwali', 3854.000, 16.000, 5.00, 'pexels-photo-11974834.jpeg'),
(32, 'Kausani', 'Kausani is a scenic hill station in Uttarakhand that is known for its panoramic views of the Himalayas and tea gardens.', 'Pantnagar Airport', 'Spring', 0.01, '3D/4N', 9.80, 'Hindi, Kumaoni, English', 1890.000, 0.000, 4.40, 'pexels-photo-8020071.jpeg'),
(33, 'Yamunotri', 'Yamunotri is a holy town in Uttarakhand that is known for its temple and hot springs.', 'Dehradun Airport', 'Summer', 0.01, '3D/4N', 11.00, 'Hindi, Garhwali, English', 3293.000, 10.000, 4.50, 'pexels-photo-13672802.jpeg'),
(34, 'Mukteshwar', 'Mukteshwar is a charming hill station in Uttarakhand that is known for its natural beauty and ancient temples.', 'Pantnagar Airport', 'Summer', 0.01, '2D/1N', 6.80, 'Hindi, Kumaoni, English', 2286.000, 0.000, 4.10, 'pexels-photo-7846563.jpeg'),
(35, 'Binsar', 'Binsar is a scenic hill station in Uttarakhand that is known for its panoramic views of the Himalayas and trekking trails.', 'Pantnagar Airport', 'All Weather', 0.01, '3D/4N', 9.50, 'Hindi, Kumaoni, English', 2412.000, 13.500, 4.60, 'pexels-photo-7846490.jpeg'),
(36, 'Gwaldam', 'Gwaldam is a scenic hill station in Uttarakhand that is known for its panoramic views and trekking trails.', 'Dehradun Airport', 'All Weather', 0.01, '2D/1N', 10.00, 'Hindi, Garhwali, English', 1706.000, 15.500, 4.70, 'pexels-photo-15896015.jpeg'),
(37, 'Hemkund Sahib', 'Hemkund Sahib is a holy Sikh shrine in Uttarakhand that is known for its scenic beauty and trekking trails.', 'Dehradun Airport', 'Summer', 0.01, '4D/5N', 16.00, 'Hindi, Garhwali, English', 4239.000, 18.500, 4.90, 'pexels-photo-574313.jpeg'),
(38, 'Badrinath', 'Badrinath is a holy town in Uttarakhand that is known for its ancient temple and scenic beauty.', 'Dehradun Airport', 'Summer', 0.01, '4D/5N', 12.00, 'Hindi, Garhwali, English', 4329.000, 0.000, 5.00, 'pexels-photo-15017640.jpeg'),
(39, 'Pithoragarh', 'Pithoragarh is a beautiful town in Uttarakhand that is known for its scenic beauty and ancient temples.', 'Pantnagar Airport', 'All Weather', 0.01, '3D/4N', 6.00, 'Hindi, Kumaoni, English', 1645.000, 0.000, 4.80, 'pexels-photo-12990547.jpeg'),
(40, 'Almora', 'Almora is a charming hill station in Uttarakhand that is known for its natural beauty and ancient temples.', 'Pantnagar Airport', 'Fall', 0.01, '2D/1N', 15.00, 'English, Hindi, Kumaoni', 1651.000, 0.000, 4.70, 'pexels-photo-12532343.jpeg'),
(41, 'Ranikhet', 'Ranikhet is a quiet hill station in Uttarakhand that is known for its natural beauty and historic temples.', 'Pantnagar Airport', 'Winter', 0.01, '2D/1N', 12.00, 'Hindi, Kumaoni, English', 1869.000, 0.000, 4.60, 'pexels-photo-16128127.jpeg'),
(42, 'Pangot', 'Pangot is a beautiful hill station in Uttarakhand that is known for its bird watching and trekking trails.', 'Pantnagar Airport', 'All Weather', 0.01, '1D/1N', 5.00, 'Hindi, Kumaoni, English', 2075.000, 8.000, 4.60, 'pexels-photo-16128124.jpeg'),
(43, 'Lansdowne', 'Lansdowne is a peaceful hill station in Uttarakhand that is known for its British-era buildings and trekking trails.', 'Dehradun Airport', 'All Weather', 0.01, '2D/1N', 5.00, 'Hindi, Garhwali, Kumaon, English', 1706.000, 0.000, 4.80, 'pexels-photo-7846656.jpeg'),
(44, 'Kedartal', 'Kedartal is a stunning lake in Uttarakhand that is known for its crystal clear water and trekking trail. It offers breathtaking views of the Himalayas and is located in the Kedarnath Wildlife Sanctuary', 'Dehradun Airport', 'Fall', 0.01, '2D/1N', 7.50, 'Hindi, Kumaoni, English', 2084.000, 0.000, 4.60, 'pexels-photo-16128131.jpeg'),
(45, 'Kanatal', 'Kanatal is a beautiful hill station in Uttarakhand that is known for its apple orchards, oak forests, and panoramic views of the Himalayas. It is a popular destination for adventure tourism and weekend getaways.', 'Dehradun Airport', 'Winter', 0.01, '2D/1N', 5.00, 'Hindi, Garhwali, English', 2590.000, 0.000, 4.60, 'pexels-photo-14064751.jpeg'),
(46, 'Chaukori', 'Chaukori is a scenic hill station in Uttarakhand that is known for its stunning views of the Himalayas and tea gardens. It is a popular destination for honeymooners and nature lovers.', 'Pantnagar Airport', 'All Weather', 0.01, '3D/2N', 10.50, 'Hindi, Kumaoni, English', 2010.000, 0.000, 4.50, 'pexels-photo-981091.jpeg'),
(47, 'Khirsu', 'Khirsu is a hidden gem in Uttarakhand that is known for its tranquil surroundings, apple orchards, and stunning views of the Himalayas', 'Dehradun Airport', 'Fall', 15.00, '2D/1N', 8.00, 'Hindi, Garhwali, English&#39;', 1700.000, 0.000, 4.50, 'pexels-photo-4913435.jpeg'),
(48, 'Rudranath', 'Rudranath is a Hindu temple dedicated to God Shiva, located in the Garhwal Himalayan mountains in Uttarakhand, India.', 'Dehradun Airport', 'Fall', 0.01, '4D/5N', 20.00, 'English, Hindi, Garhwali', 3600.000, 22.000, 5.00, 'pexels-photo-11305767.jpeg'),
(49, 'Deoria Tal', 'Deoria Tal is a high-altitude lake in Uttarakhand that is known for its serene environment, reflection of the Chaukhamba peaks, and trekking opportunities. It is a popular destination for nature lovers, adventure enthusiasts, and birdwatchers.', 'Dehradun Airport', 'Spring', 0.01, '2D/1N', 6.50, 'Hindi, Garhwali, English', 2438.000, 4.800, 4.70, 'pexels-photo-914128.jpeg'),
(50, 'Kartik Swami Temple', 'Kartik Swami Temple is a sacred temple in Uttarakhand that is known for its scenic beauty and panoramic views of the Himalayas. It is a popular destination for spiritual tourism, trekking, and nature walks.', 'Dehradun Airport', 'Winter', 0.01, '1D/1N', 8.00, 'Hindi, Garhwali, English', 3050.000, 3.500, 5.00, 'pexels-photo-10432964.jpeg'),
(51, 'Dhanaulti', 'Dhanaulti is a quiet hill station at an elevation of 2286 meters above sea level, it offers panoramic views of the lofty Himalayas.', 'Dehradun Airport', 'winter', 0.10, '2D/1N', 4.00, 'English/Hindi/Garhwali', 2286.000, 0.000, 4.10, 'pexels-photo-7846476.jpeg'),
(53, 'kotdwar', 'Kotdwara (Kotdwar) is located at the foothills of the Shivaliks at a distance of 101 kms from Pauri. It is the entrance to hills in Pauri region of Uttarakhand, and literally means &#39;Gateway to Garhwal&#39;.', 'Dehradun Airport', 'All Weather', 1.10, '1D/1N', 4.00, 'English/Hindi/Garhwali/Kumoani', 454.000, 0.000, 4.10, 'pexels-photo-257092.webp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`destination_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `destination_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
