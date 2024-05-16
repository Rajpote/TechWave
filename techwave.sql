-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 10:16 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techwave`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_register`
--

CREATE TABLE `admin_register` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phnumber` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_register`
--

INSERT INTO `admin_register` (`id`, `name`, `email`, `phnumber`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', '9800000005', '$2y$10$F8tBVfcNvPmr0ltEudcsDe4ART0mOrh323YQk3eAC8YHe9MNU3oYa');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `itemId` int(100) NOT NULL,
  `id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `feedback` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `g_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `uname`, `feedback`, `rating`, `g_id`, `created_at`, `status`) VALUES
(4, 'rrajpote@gmail.com', 'good product', '5.00', 5, '2024-03-14 02:23:17', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `order_data`
--

CREATE TABLE `order_data` (
  `order_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_data`
--

INSERT INTO `order_data` (`order_id`, `id`, `g_id`, `gname`, `price`, `quantity`, `transaction_id`) VALUES
(1, 9, 1, 'Apple iPhone 14 Pro', 500, 1, '8aVRpPTmnmJK6Fzp4ijj35'),
(2, 9, 1, 'Apple iPhone 14 Pro', 500, 1, 'Ax9hbvJpAvTLzjA5fzowaZ'),
(3, 9, 7, 'Apple iPhone 15 Pro Max', 214, 1, 'CpR5JKASC3QEPcpnmddT5b'),
(4, 9, 2, 'Samsung Galaxy A05', 140, 1, 'CpR5JKASC3QEPcpnmddT5b'),
(5, 9, 10, 'Iphone 11', 123, 2, 'TtcqMq8N9A7m8enbKGUmtX'),
(6, 9, 1, 'Apple iPhone 14 Pro', 350, 2, 'TwkZet3L934GENubsUJUFH'),
(7, 9, 2, 'Samsung Galaxy A05', 140, 1, 'oc8ShS3pgPr8sxpz6GpwqS'),
(8, 9, 2, 'Samsung Galaxy A05', 140, 2, 'TBcw2syYUtjCMnE4DvcyBC');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `g_id` int(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `gname` varchar(255) NOT NULL,
  `gspecification` varchar(1500) NOT NULL,
  `gimage` varchar(255) NOT NULL,
  `imageone` varchar(255) NOT NULL,
  `imagetwo` varchar(255) NOT NULL,
  `gprice` int(11) NOT NULL,
  `gdis` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`g_id`, `type`, `category`, `gname`, `gspecification`, `gimage`, `imageone`, `imagetwo`, `gprice`, `gdis`) VALUES
(1, 'Apple', 'bestbuy', 'Apple iPhone 14 Pro', '    Design: Ceramic Shield front, Textured matte glass back and stainless steel design\r\n    Capacity: 128 GB, 256GB, 512GB, 1TB\r\n    Display: 6.1‑inch all‑screen OLED Super Retina XDR display with 2556‑by‑1179-pixel resolution at 460 ppi, HDR display, True Tone\r\n    Chip: A16 Bionic chip\r\n    Processor: 6‑core CPU with 2 performance and 4 efficiency cores, 5‑core GPU, 16‑core Neural Engine\r\n    Rear Camera: 48MP Main: 24 mm, ƒ/1.78 aperture, second-generation sensor-shift optical image stabilization, seven‑element lens, 100% Focus Pixels, 12MP Ultra Wide: 13 mm, ƒ/2.2 aperture and 120° field of view, six‑element lens, 100% Focus Pixel, 12MP 2x Telephoto (enabled by quad-pixel sensor): 48 mm, ƒ/1.78 aperture, second-generation sensor-shift optical image stabilization, seven‑element lens, 100% Focus Pixels, 12MP 3x Telephoto: 77 mm, ƒ/2.8 aperture, optical image stabilization, six-element lens\r\n    Front Camera: 12MP camera, ƒ/1.9 aperture, Autofocus with Focus Pixels\r\n    Video Recording: 4K video recording at 24 fps, 25 fps, 30 fps, or 60 fps, 1080p HD video recording at 25 fps, 30 fps, or 60 fps, 720p HD video recording at 30 fps, Cinematic mode up to 4K HDR at 30 fps, Action mode up to 2.8K at 60 fps\r\n    Operating System: iOS 16\r\n    Battery: Built‑in rechargeable lithium‑ion battery, MagSafe wireless charging up to 15W, Qi wireless charging up to 7.5W, Charging via USB to computer system or power adapter\r\n    Fast-charge capable: Up to 50% charge in around 30 minutes', 'Apple iPhone 14 Pro.jpg', 'Apple iPhone 14 Pro (Gold, 128GB).jpg', 'Apple iPhone 14 Pro.jpg', 350, ''),
(2, 'Samsung ', 'bestbuy', 'Samsung Galaxy A05', '    • Samsung Galaxy A05 (Black, 4GB, 64GB Storage)\r\n    • 50 MP Main Camera, 4 Rear Cameras\r\n    • 8MP Front Camera, 6.7 Inch Screen\r\n    • MediaTek Helio G85, 4G Network Connections\r\n    • 5000 mAh Battery, 25w Fast Charging\r\n    • Corning Gorilla Glass 5, Plastic Build Type\r\n    • 2 SIM Slots, Model Year 2023', 'Samsung-Galaxy-A05-Black.jpg', 'Samsung-Galaxy-A05-Black.jpg', 'Samsung-Galaxy-A05-Black.jpg', 140, ''),
(3, 'Samsung ', 'deals', 'Samsung Galaxy S24 Ultra 5G', '    Body: 233 grams, IP68 rated, Titanium frame, S-pen support\r\n    Display: 6.8-inches Dynamic AMOLED 2X Infinity-O, Gorilla Glass Armor, Adaptive 120Hz refresh rate, Vision Booster, up to 2600 nits (peak)\r\n    Resolution: QHD+ (3088 x 1440 pixels)\r\n    Chipset: Snapdragon 8 Gen 3 for Galaxy (4nm mobile platform)\r\n    Memory: 12GB LPDDR5X RAM, 256GB UFS 4.0 storage\r\n    Software & UI: One UI 6.1 on top of Android 14\r\n    Rear Camera: Quad (with LED flash)– 200MP primary lens, OIS, PDAF– 12MP ultra-wide-angle lens, 120º FOV– 10MP telephoto lens, 3x optical zoom– 50MP telephoto lens, 5x optical zoom, 100x digital zoom\r\n    Front Camera: 12MP f/2.2 lens\r\n    Security: Ultrasonic fingerprint sensor\r\n    Battery: 5000mAh with 45W fast charging, 15W wireless charging\r\n    Colors: Black, Violet, Grey', 'Samsung-Galaxy-S24-Ultra.jpg', 's24ulter.jpg', 'Samsung-Galaxy-S24-Ultra.jpg', 184, ''),
(4, 'xiaomi', 'deals', 'Redmi Note 13 Pro+ 5G', 'Display:\r\n6.67\" CrystalRes AMOLED display\r\nRefresh rate: Up to 120Hz\r\nBrightness: 1800nits peak brightness\r\nResolution: 2712x1220, 446PPI\r\nProtection: Corning® Gorilla® Glass Victus®\r\n\r\nProcessor:\r\nMediaTek Dimensity 7200-Ultra 4nm process technology\r\nOcta-core processor, up to 2.8GHz\r\n\r\nCamera:\r\nRear Camera: 200MP main camera with OIS\r\nFront Camera: 16MP camera\r\n\r\nBattery & Charging:\r\n5000mAh battery(typ) + Supports 120W HyperCharge\r\n\r\nSecurity:\r\nIn-screen fingerprint sensor\r\nAI Face Unlock\r\nConnectivity:\r\n\r\nNFC: Yes\r\n\r\nAudio:\r\nDual speakers\r\nSupports Dolby Atmos®\r\n\r\nOperating System:\r\nMIUI 14', 'Untitled.jpg', 'note13pro.jpg', 'note13pro.jpg', 52, ''),
(5, 'Realme ', 'bestbuy', 'realme 11 Pro', 'Display: 6.7-inch Full HD+ sAMOLED screen, 120Hz refresh rate, 2412×1080 pixels resolution, 61° Curved, 0.65mm Double-ReinforcedGlass\r\nChipset: MediaTek Dimensity 7050 5G (6nm)\r\nCPU: Octa-core (2x2.6 GHz Cortex-A78 & 6x2.0 GHz Cortex-A55)\r\nGPU: Arm Mali-G68 MC4\r\nRAM: 8GB LPDDR4x, Supports DRE\r\nStorage: 256GB UFS 3.1\r\nSIM: Dual SIM (nano + nano)\r\nOperating System: realmeUI 4.0 Based on Android 13\r\nBack Camera(s): 100MP OIS primary (f/1.75 aperture), 2MP macro sensor (f/2.4 aperture)\r\nFront Camera: 16MP (f/2.45 aperture)\r\nSecurity: In-display fingerprint sensor, Face-unlock\r\nConnectivity: Bluetooth 5.2, WiFi-6, USB Type-C\r\nBattery: 5000mAh with 67W SuperVOOC Charge\r\nAudio: Dolby Atmos dual speakers', 'realme 11.jpg', 'Realme 11 Pro+ Price And Specifications.jpg', 'Realme 11 Pro+ Price And Specifications.jpg', 47, ''),
(7, 'Apple ', 'deals', 'Apple iPhone 15 Pro Max', 'Display: 6.7″ Super Retina XDR OLED display with Dynamic Island + Always-On display\r\nResolution: 2796x1290 pixels with 460 ppi\r\nContrast Ratio: 20,00,000:1 + True Tone display\r\nChipset: A17 Prochip+ 6-core CPU + 6-core GPU + 16-core Neural Engine\r\nRear Camera: 48MP dual-camera with ƒ/1.78 aperture, Sensor-shift optical image stabilization\r\nUltra Wide Camera: 12MP, ƒ/2.2 aperture\r\nTelephoto: 12MP, ƒ/2.8 aperture, Second-generation sensor-shift optical image stabilization\r\nVideo Recording: 4K at 24 fps, 25 fps, 30 fps, or 60 fps + 1080p HD at 25 fps, 30 fps, or 60 fps + Cinematic mode for recording videos with shallow depth of field (up to 4K HDR at 30 fps)\r\nFront Camera: 12MP TrueDepth front camera with ƒ/1.9 aperture + Photonic Engine + 4K video recording at various frame rates\r\nSafety: Emergency SOS + Crash Detection\r\nPower and Battery: Built-in rechargeable lithium-ion battery, MagSafe, and Qi wireless charging, Fast-charge capable: Up to 50% charge in 35 minutes with 20W adapter or higher\r\nSecure Authentication: FaceTime video, Enabled by TrueDepth front camera for facial recognition\r\nSensors: LiDAR Scanner, High dynamic range gyro, High-g accelerometer, Proximity sensor, Dual ambient light sensors, Barometer\r\nSIM Card: Dual SIM (Two active eSIMs or nano-SIM and eSIM)\r\nConnector: USB-C, Supports USB 3', 'iPhone-15-Pro-Max-Blue-Titanium.jpg', '98.jpg', '98.jpg', 214, 'IPhone 15 Pro. Forged in titanium and featuring the groundbreaking A17 Pro chip, a customizable Action button, and a more versatile Pro camera system.'),
(8, 'Oneplus', 'article', 'OnePlus 12 5G', '\r\nDimensions: 164.3 x 75.8 x 9.2 mm, Weight: 220 g\r\nDisplay: LTPO AMOLED, 6.82 inches, 1440 x 3168 pixels, 120Hz\r\nPlatform: Android 14, Snapdragon 8 Gen 3, Octa-core CPU\r\nMemory: 512GB + 16GB RAM\r\nMain Camera: Triple 50 MP + 64 MP + 48 MP, 8K video\r\nSelfie Camera: 32 MP\r\nSound: Stereo speakers, No 3.5mm jack\r\nComms: Wi-Fi 6e, Bluetooth 5.4, NFC, USB Type-C 3.2\r\nFeatures: Under-display fingerprint sensor, Various sensors\r\nBattery: 5400 mAh, 100W wired charging, 50W wireless chargin', 'OnePlus-12-Black.jpg', 'OnePlus 12R Genshin Impact Edition_ Price and Availability Details Unveiled.jpg', 'OnePlus 12R Genshin Impact Edition_ Price and Availability Details Unveiled.jpg', 139, 'OnePlus creates beautifully designed products with premium build quality & brings the best technology to users around the world.'),
(9, 'Oneplus', 'article', 'OnePlus Nord 3 5G', 'Size: 17.12 cm (6.74 inches)\r\nResolution: 2772 x 1240 pixels, 450 ppi\r\nScreen-to-body Ratio: 93.5%\r\nRefresh Rate: 40-120 Hz (dynamic)\r\nType: 120 Hz Super Fluid AMOLED\r\nTouch Response Rate: Up to 1000 Hz\r\nColor Support: sRGB, Display P3, 10-bit depth, HDR10+\r\nOperating System: OxygenOS 13.1 (based on Android™ 13)\r\nCPU: MediaTek Dimensity 9000\r\nGPU: Arm® Mali G710 MC10\r\nRAM and Storage: 16 GB RAM, 256 GB Storage\r\nBattery: 5000mAh (Dual-cell 2,500 mAh, non-removable) with 80W SUPERVOOC charge\r\nMain Camera: 50 MP Sony IMX890 + 8 MP 112° Ultra-Wide Camera + 2 MP Macro Lens\r\nSensors: In-display Fingerprint, Accelerometer, Compass, Gyroscope, Ambient Light, Proximity, Sensor Core, Rear Color Temperature, Infrared Blaster\r\nAudio: Dual Stereo Speakers, Noise cancellation, Dolby Atmos®', 'One-Plus-Nord-3-Misty-Green.jpg', 'images-kv-bg-1.jpg-ezgif.com-webp-to-png-converter.png', 'images-kv-bg-1.jpg-ezgif.com-webp-to-png-converter.png', 69, '\r\nThe OnePlus Nord 3 5G boasts a sleek design that exudes elegance. Available in Tempest Gray and Misty Green, its 2.8D silk glass cover in Tempest Gray resists glare and fingerprints, while the Misty Green variant features a subtle glossy celadon finish. '),
(10, 'Apple', 'select', 'Iphone 11', 'asd', 'Apple iPhone 11 - 256GB - Black (Sprint) A2111 (CDMA + GSM) for sale online _ eBay.jpg', 'Apple iPhone 11 - 256GB - Black (Sprint) A2111 (CDMA + GSM) for sale online _ eBay.jpg', 'Apple iPhone 11 - 256GB - Black (Sprint) A2111 (CDMA + GSM) for sale online _ eBay.jpg', 123, 'sad'),
(11, 'Realme', 'article', 'realme GT 2 PRO', 'Display: World’s First 2K Flat Display with LTPO 2.0 Paper Tech Master Design\r\nConnectivity: Max Ultra Wide Band HyperSmart Antenna Switching\r\nPerformance: Qualcomm SM8450 Snapdragon 8 Gen 1 (4 nm)\r\nMemory: 12 GB RAM, 256 GB ROM\r\nSecurity: Ultra-fast In-display Fingerprint Sensor with Heart Rate Test Support\r\nBattery: 65W SuperDart Charge/5000mAh Massive Battery\r\nCamera: 50MP SONY IMX766 OIS Primary + 50MP Ultra Wide-angle + 3MP Microscope Rear Camera, 32MP Selfie Camera/SONY IMX615 Sensor Front Camera\r\nMaterial: ISCC-certified Biopolymer Rear Panel\r\nNetwork: 5G/4G/3G/2G Cellular, 2.4GHz/5GHz Wi-Fi\r\nCharging: Fast Charging: 65W, 100% in 33 min (advertised)\r\nSIM: Dual Nano SIM Card Slots\r\nSensors: Magnetic Induction Sensor, Dual Light Sensors, Dual Color Temperature Sensors, Proximity Sensor, Gyro-meter, Acceleration Sensor\r\nOperating System: Android 12, Realme UI 3.0\r\nNFC: 360° NFC', 'Realme-GT-2-Pro-Design-and-Display.jpg', 'Realme-GT-2-Pro-Price-in-Nepal-2022.jpg', 'Realme-GT-2-Pro-Price-in-Nepal-2022.jpg', 109, 'A premium flagship that doesn’t cost the earthWorld\'s first biopolymer design\r\nDerived from renewable resources such as paper pulp, SABIC’s biopolymer reduces carbon emissions during manufacturing of the rear panel by 35.5%. ');

-- --------------------------------------------------------

--
-- Table structure for table `profile_info`
--

CREATE TABLE `profile_info` (
  `id` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `phnumber` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_info`
--

INSERT INTO `profile_info` (`id`, `uname`, `phnumber`, `email`) VALUES
(1, '', '', ''),
(2, 'userraj', '90874890', 'rrajpote@gmail.com'),
(3, 'User', '9800000001', 'user1@gmail.com'),
(4, 'asd', '9876543210', 'asd@gmail.com'),
(5, 'raj123', '9812345678', 'user@gmail.com'),
(6, 'rajpote', '987894561', 'rrajpote@gmail.com'),
(7, 'rajuser', '9845615897', 'rajuser@gmail.com'),
(8, 'Rajpote', '9811897922', 'rrajpote@gmail.com'),
(9, 'admin', '9812345879', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(20) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phnumber` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `uname`, `password`, `email`, `phnumber`) VALUES
(9, 'Rajpote', '$2y$10$Q4Hl3Ri467bvH5jH0KyrY.FnHIHYA4ide6/53eGK4iZd6Uablyuqe', 'rrajpote@gmail.com', '9811897922'),
(10, 'admin', '$2y$10$T2nGSfMU87fyIq0LaaEPIeic98gO4Rc89CjBP.v8vwdj1toW6.LgC', 'admin@gmail.com', '2147483647');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_register`
--
ALTER TABLE `admin_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `order_data`
--
ALTER TABLE `order_data`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `profile_info`
--
ALTER TABLE `profile_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_register`
--
ALTER TABLE `admin_register`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `itemId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_data`
--
ALTER TABLE `order_data`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `g_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `profile_info`
--
ALTER TABLE `profile_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
