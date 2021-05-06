-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 10:03 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odontologia`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslist`
--

CREATE TABLE `accesslist` (
  `id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accesslist`
--

INSERT INTO `accesslist` (`id`, `action`) VALUES
(1, 'agendar cita'),
(2, 'eliminar cita'),
(3, 'agregar cliente'),
(4, 'editar cliente'),
(5, 'agregar caso'),
(6, 'editar caso'),
(7, 'crear usuarios'),
(8, 'administrar'),
(9, 'editar usuarios'),
(10, 'eliminar usuarios');

-- --------------------------------------------------------

--
-- Table structure for table `administrativestatuslist`
--

CREATE TABLE `administrativestatuslist` (
  `id` int(11) NOT NULL,
  `administrativeStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrativestatuslist`
--

INSERT INTO `administrativestatuslist` (`id`, `administrativeStatus`) VALUES
(1, 'Moroso'),
(2, 'Cancelado'),
(3, 'Al día'),
(4, 'Al día (pendiente)');

-- --------------------------------------------------------

--
-- Table structure for table `judicialstatuslist`
--

CREATE TABLE `judicialstatuslist` (
  `id` int(11) NOT NULL,
  `judicialStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `judicialstatuslist`
--

INSERT INTO `judicialstatuslist` (`id`, `judicialStatus`) VALUES
(1, 'Revisión de expediente'),
(2, 'Audiencia'),
(3, 'Señalamiento de remate'),
(4, 'Prevención'),
(5, 'Revocatoria'),
(6, 'Apelación'),
(7, 'Apelación por inadmisión'),
(8, 'Expresión de agravios'),
(9, 'Aclaración y Adición'),
(10, 'Oposición a intereses'),
(11, 'Actividad procesal defectuosa'),
(12, 'Incidente de anulidad de remate'),
(13, 'Recurso de revisión (Sala de casación)'),
(14, 'Incidente de cobro de honorarios'),
(15, 'Varios'),
(16, 'Información al cliente'),
(17, 'Archivo'),
(18, 'Archivo definitivo');

-- --------------------------------------------------------

--
-- Table structure for table `legalcase`
--

CREATE TABLE `legalcase` (
  `id` int(11) NOT NULL,
  `internalCode` varchar(50) NOT NULL,
  `subjectID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `judicialStatusID` int(11) NOT NULL,
  `administrativeStatusID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `nextNotification` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `legalcasenoteshistory`
--

CREATE TABLE `legalcasenoteshistory` (
  `id` int(11) NOT NULL,
  `note` varchar(150) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `legalCaseID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rolelist`
--

CREATE TABLE `rolelist` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rolelist`
--

INSERT INTO `rolelist` (`id`, `role`) VALUES
(1, 'Administrador'),
(2, 'Legal'),
(3, 'Financiero'),
(4, 'Servicio Cliente');

-- --------------------------------------------------------

--
-- Table structure for table `roleprivilegeaccess`
--

CREATE TABLE `roleprivilegeaccess` (
  `id` int(11) NOT NULL,
  `accessID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subjectlist`
--

CREATE TABLE `subjectlist` (
  `id` int(11) NOT NULL,
  `subject` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjectlist`
--

INSERT INTO `subjectlist` (`id`, `subject`) VALUES
(1, 'Monitorio'),
(2, 'Hipotecario'),
(3, 'Notariado'),
(4, 'Contencioso Administrativo'),
(5, 'Cobro Efectivo'),
(6, 'Penal'),
(7, 'Familia'),
(8, 'Laboral');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `personalID` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `lastName1` varchar(150) NOT NULL,
  `lastName2` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(150) NOT NULL,
  `roleID` int(11) NOT NULL,
  `verificationKey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `personalID`, `name`, `lastName1`, `lastName2`, `status`, `dateCreated`, `phone`, `email`, `password`, `address`, `roleID`, `verificationKey`) VALUES
(1, '113100938', 'Christian', 'Campos', 'Olivares', 1, '2021-01-20 04:37:29', '83180160', 'ccamposcr@gmail.com', '$2y$10$noVtfVJq7ZuRvY8qQKDQ8OYKB6bxGzsY8mDvrsyGVd79xfjMo4xdC', '125m al oeste y 25 al sur de la Cruz Roja de Vazquez de Coronado', 1, 'f1dd491af6c0ef9337d9a77f5618bcf4');

-- --------------------------------------------------------

--
-- Table structure for table `userappointment`
--

CREATE TABLE `userappointment` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesslist`
--
ALTER TABLE `accesslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrativestatuslist`
--
ALTER TABLE `administrativestatuslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `judicialstatuslist`
--
ALTER TABLE `judicialstatuslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legalcase`
--
ALTER TABLE `legalcase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legalcasenoteshistory`
--
ALTER TABLE `legalcasenoteshistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rolelist`
--
ALTER TABLE `rolelist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roleprivilegeaccess`
--
ALTER TABLE `roleprivilegeaccess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjectlist`
--
ALTER TABLE `subjectlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userappointment`
--
ALTER TABLE `userappointment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesslist`
--
ALTER TABLE `accesslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `administrativestatuslist`
--
ALTER TABLE `administrativestatuslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `judicialstatuslist`
--
ALTER TABLE `judicialstatuslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `legalcase`
--
ALTER TABLE `legalcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `legalcasenoteshistory`
--
ALTER TABLE `legalcasenoteshistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rolelist`
--
ALTER TABLE `rolelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roleprivilegeaccess`
--
ALTER TABLE `roleprivilegeaccess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subjectlist`
--
ALTER TABLE `subjectlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `userappointment`
--
ALTER TABLE `userappointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
