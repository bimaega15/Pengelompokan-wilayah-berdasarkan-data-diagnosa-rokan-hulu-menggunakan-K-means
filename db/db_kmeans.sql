-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Agu 2022 pada 10.57
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kmeans`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `coordinate`
--

CREATE TABLE `coordinate` (
  `id_coordinate` int(11) NOT NULL,
  `letak_coordinate` varchar(200) NOT NULL,
  `inisialisasi_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `coordinate`
--

INSERT INTO `coordinate` (`id_coordinate`, `letak_coordinate`, `inisialisasi_detail_id`) VALUES
(1, '100.53,0.71', 491),
(2, '100.54,0.71', 492),
(3, '100.55,0.7', 493),
(4, '100.5,0.74', 494),
(5, '100.52,0.71', 495);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dataset`
--

CREATE TABLE `dataset` (
  `id_dataset` int(11) NOT NULL,
  `kode_dataset` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `dataset`
--

INSERT INTO `dataset` (`id_dataset`, `kode_dataset`) VALUES
(1, 'P1'),
(2, 'P2'),
(3, 'P3'),
(4, 'P4'),
(5, 'P5'),
(6, 'P6'),
(7, 'P7'),
(8, 'P8'),
(9, 'P9'),
(10, 'P10'),
(11, 'P11'),
(12, 'P12'),
(13, 'P13'),
(14, 'P14'),
(15, 'P15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dataset_detail`
--

CREATE TABLE `dataset_detail` (
  `id_dataset_detail` int(11) NOT NULL,
  `dataset_id` int(11) NOT NULL,
  `inisialisasi_id` int(11) NOT NULL,
  `inisialisasi_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `dataset_detail`
--

INSERT INTO `dataset_detail` (`id_dataset_detail`, `dataset_id`, `inisialisasi_id`, `inisialisasi_detail_id`) VALUES
(1, 1, 6, 37),
(2, 1, 7, 38),
(3, 1, 9, 55),
(4, 1, 8, 52),
(5, 1, 10, 491),
(6, 2, 6, 37),
(7, 2, 7, 39),
(8, 2, 9, 56),
(9, 2, 8, 52),
(10, 2, 10, 492),
(11, 3, 6, 37),
(12, 3, 7, 40),
(13, 3, 9, 57),
(14, 3, 8, 53),
(15, 3, 10, 492),
(16, 4, 6, 37),
(17, 4, 7, 39),
(18, 4, 9, 58),
(19, 4, 8, 52),
(20, 4, 10, 493),
(21, 5, 6, 36),
(22, 5, 7, 40),
(23, 5, 9, 59),
(24, 5, 8, 52),
(25, 5, 10, 494),
(26, 6, 6, 37),
(27, 6, 7, 39),
(28, 6, 9, 60),
(29, 6, 8, 52),
(30, 6, 10, 492),
(31, 7, 6, 37),
(32, 7, 7, 41),
(33, 7, 9, 61),
(34, 7, 8, 52),
(35, 7, 10, 493),
(36, 8, 6, 37),
(37, 8, 7, 41),
(38, 8, 9, 55),
(39, 8, 8, 52),
(40, 8, 10, 495),
(41, 9, 6, 36),
(42, 9, 7, 41),
(43, 9, 9, 62),
(44, 9, 8, 52),
(45, 9, 10, 492),
(46, 10, 6, 36),
(47, 10, 7, 41),
(48, 10, 9, 63),
(49, 10, 8, 52),
(50, 10, 10, 493),
(51, 11, 6, 37),
(52, 11, 7, 41),
(53, 11, 9, 55),
(54, 11, 8, 52),
(55, 11, 10, 492),
(56, 12, 6, 37),
(57, 12, 7, 41),
(58, 12, 9, 64),
(59, 12, 8, 52),
(60, 12, 10, 493),
(61, 13, 6, 37),
(62, 13, 7, 41),
(63, 13, 9, 55),
(64, 13, 8, 52),
(65, 13, 10, 493),
(66, 14, 6, 36),
(67, 14, 7, 41),
(68, 14, 9, 55),
(69, 14, 8, 52),
(70, 14, 10, 492),
(71, 15, 6, 37),
(72, 15, 7, 41),
(73, 15, 9, 65),
(74, 15, 8, 52),
(75, 15, 10, 492);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `jumlah_cluster` int(11) NOT NULL,
  `iterasi` int(5) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `jumlah_cluster`, `iterasi`, `users_id`) VALUES
(3, 5, 3, 1),
(4, 4, 3, 1),
(5, 3, 4, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_detail`
--

CREATE TABLE `hasil_detail` (
  `id_hasil_detail` int(11) NOT NULL,
  `cluster` int(11) NOT NULL,
  `jarak` double NOT NULL,
  `hasil_id` int(11) NOT NULL,
  `dataset_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil_detail`
--

INSERT INTO `hasil_detail` (`id_hasil_detail`, `cluster`, `jarak`, `hasil_id`, `dataset_id`) VALUES
(3989, 3, 1.9364916731037, 3, 1),
(3990, 3, 1.1180339887499, 3, 2),
(3991, 0, 1.9202864369672, 3, 3),
(3992, 0, 0.82915619758885, 3, 4),
(3993, 0, 1.6393596310755, 3, 5),
(3994, 0, 1.7853571071357, 3, 6),
(3995, 1, 0.86602540378444, 3, 7),
(3996, 4, 1, 3, 8),
(3997, 1, 0.86602540378444, 3, 9),
(3998, 2, 1.2472191289246, 3, 10),
(3999, 3, 1.3228756555323, 3, 11),
(4000, 2, 0.47140452079103, 3, 12),
(4001, 4, 1, 3, 13),
(4002, 3, 1.5, 3, 14),
(4003, 2, 1.2472191289246, 3, 15),
(4004, 0, 2.0766559657295, 4, 1),
(4005, 0, 0.55901699437495, 4, 2),
(4006, 0, 1.3462912017836, 4, 3),
(4007, 0, 1.8200274723201, 4, 4),
(4008, 1, 1.5634719199411, 4, 5),
(4009, 1, 1.4529663145136, 4, 6),
(4010, 1, 1.4529663145136, 4, 7),
(4011, 2, 2.0155644370746, 4, 8),
(4012, 3, 1.6583123951777, 4, 9),
(4013, 3, 0.86602540378444, 4, 10),
(4014, 2, 1.0307764064044, 4, 11),
(4015, 3, 0.86602540378444, 4, 12),
(4016, 2, 0.25, 4, 13),
(4017, 2, 1.25, 4, 14),
(4018, 3, 1.6583123951777, 4, 15),
(4019, 0, 2.0766559657295, 5, 1),
(4020, 0, 0.55901699437495, 5, 2),
(4021, 0, 1.3462912017836, 5, 3),
(4022, 0, 1.8200274723201, 5, 4),
(4023, 1, 3.3624577988399, 5, 5),
(4024, 1, 2.6764277135993, 5, 6),
(4025, 1, 1.2037356818823, 5, 7),
(4026, 2, 2.0155644370746, 5, 8),
(4027, 1, 1.0101525445522, 5, 9),
(4028, 1, 1.2616801237611, 5, 10),
(4029, 2, 1.0307764064044, 5, 11),
(4030, 1, 2.1092604371762, 5, 12),
(4031, 2, 0.25, 5, 13),
(4032, 2, 1.25, 5, 14),
(4033, 1, 3.1428571428571, 5, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `inisialisasi`
--

CREATE TABLE `inisialisasi` (
  `id_inisialisasi` int(11) NOT NULL,
  `nama_inisialisasi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `inisialisasi`
--

INSERT INTO `inisialisasi` (`id_inisialisasi`, `nama_inisialisasi`) VALUES
(6, 'jenis kelamin'),
(7, 'jenis peserta'),
(8, 'status pulang'),
(9, 'diagnosa'),
(10, 'Desa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inisialisasi_detail`
--

CREATE TABLE `inisialisasi_detail` (
  `id_inisialisasi_detail` int(11) NOT NULL,
  `nama_inisialisasi_detail` varchar(200) NOT NULL,
  `bobot_inisialisasi_detail` int(11) NOT NULL,
  `inisialisasi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `inisialisasi_detail`
--

INSERT INTO `inisialisasi_detail` (`id_inisialisasi_detail`, `nama_inisialisasi_detail`, `bobot_inisialisasi_detail`, `inisialisasi_id`) VALUES
(36, 'Laki-laki', 1, 6),
(37, 'Perempuan', 2, 6),
(38, 'Pegawai Pemerintah Dengan perjanjian kerja', 1, 7),
(39, 'PNS daerah', 2, 7),
(40, 'Pensiun PNS', 3, 7),
(41, 'PBI (APBN)', 4, 7),
(42, 'Pekerja mandiri', 5, 7),
(43, 'PBI (APBD)', 6, 7),
(44, 'Pegawai Swasta', 7, 7),
(45, 'Prajurit AD', 8, 7),
(46, 'Anggota Polri', 9, 7),
(47, 'Veteran', 10, 7),
(48, 'PNS Pusat', 11, 7),
(49, 'pensiun swasta', 12, 7),
(50, 'Pegawai BUMN', 13, 7),
(51, 'Dewan perwakilan Rakyat daerah ', 14, 7),
(52, 'berobat jalan', 1, 8),
(53, 'Rujuk Vertikal', 2, 8),
(54, 'Sembuh', 3, 8),
(55, 'Acute upper respiratory infections of multiple and unspecified sites', 1, 9),
(56, 'Nonsuppurative otitis media', 2, 9),
(57, 'Chronic ischaemic heart disease', 3, 9),
(58, 'Diarrhoea and gastroenteritis of\npresumed infectious origin', 4, 9),
(59, 'Atopic dermatitis', 5, 9),
(60, 'Pure hypercholesterolaemia', 6, 9),
(61, 'Acute nasopharyngitis[common cold]', 7, 9),
(62, 'Typhoid fever', 8, 9),
(63, 'Retained dental root', 9, 9),
(64, 'Other benign neoplasms of connective and other soft tissue', 10, 9),
(65, 'Essential (primary)\nhypertension', 11, 9),
(66, 'Chronic obstructive pulmonary disease with acute lower respiratory infection', 12, 9),
(67, 'Acute upper respiratory infection, unspecified', 13, 9),
(68, 'Dyspepsia', 14, 9),
(69, 'Thyrotoxicosis\n[hyperthyroidism]', 15, 9),
(70, 'Disorders of lipoprotein metabolism and other lipidaemias', 16, 9),
(71, 'Chronic obstructive pulmonary disease, unspecified', 17, 9),
(72, 'Follow-up examination after combined treatment for other conditions', 18, 9),
(73, 'Other and unspecified abdominal pain', 20, 9),
(74, 'Hypertensive heart disease', 21, 9),
(75, 'Gastric ulcer', 22, 9),
(76, 'Cellulitis, unspecified', 23, 9),
(77, 'Influenza due to other identified influenza virus', 24, 9),
(78, 'Fever, unspecified', 25, 9),
(79, 'Typhus fever, unspecified', 26, 9),
(80, 'Examination and encounter for administrative purposes', 27, 9),
(81, 'Bronchitis, not specified as acute or chronic', 28, 9),
(82, 'Acute renal failure', 29, 9),
(83, 'Fracture of upper end of humerus, closed', 30, 9),
(84, 'Non-insulin-dependent', 31, 9),
(85, 'Gastritis, unspecified', 32, 9),
(86, 'Other arthritis', 33, 9),
(87, 'Acute tonsillitis', 34, 9),
(88, 'Other surgical follow-up care', 35, 9),
(89, 'Pure', 36, 9),
(90, 'Low vision, both eyes', 37, 9),
(91, 'Follow-up examination', 38, 9),
(92, 'Congestive heart failure', 39, 9),
(93, 'Disturbances in tooth eruption', 40, 9),
(94, 'Senile cataract', 41, 9),
(95, 'Pulpitis', 42, 9),
(96, 'Necrosis of pulp', 43, 9),
(97, 'Tuberculosis of lung, confirmed by unspecified means', 44, 9),
(98, 'Polyneuropathy, unspecified', 45, 9),
(99, 'Pterygium', 46, 9),
(100, 'Enterobiasis', 47, 9),
(101, 'Follow-up examination after treatment for conditions other than malignant neoplasms', 48, 9),
(102, 'Supervision of normal pregnancy', 49, 9),
(103, 'Non-insulin-dependent diabetes mellitus', 50, 9),
(104, 'Follow-up examination after surgery for other conditions', 51, 9),
(105, 'Supervision of high-risk pregnancy', 52, 9),
(106, 'Angina pectoris, unspecified', 53, 9),
(107, 'Erysipelas', 54, 9),
(108, 'Hypertensive heart', 55, 9),
(109, 'Gastro-oesophageal reflux', 56, 9),
(110, 'Tinea pedis', 57, 9),
(111, 'Other polyneuropathies', 58, 9),
(112, 'Contraceptive', 59, 9),
(113, 'Acute nasopharyngitis', 60, 9),
(114, 'Acute appendicitis', 61, 9),
(115, 'Urethritis and urethral syndrome', 62, 9),
(116, 'Other disorders of nervous system, not elsewhere classified', 63, 9),
(117, 'Tinea corporis', 64, 9),
(118, 'General medical examination', 65, 9),
(119, 'Injury of unspecified body region', 66, 9),
(120, 'Acute tonsillitis unspecified', 67, 9),
(121, 'Haemorrhoids', 68, 9),
(122, 'Epilepsy', 69, 9),
(123, 'Hyperkinetic disorder, unspecified', 70, 9),
(124, 'Stomatitis and related lesions', 71, 9),
(125, 'Typhus fever', 72, 9),
(126, 'Nonsuppurative otitis media, unspecified', 73, 9),
(127, 'Atopic dermatitis, unspecified', 74, 9),
(128, 'Hordeolum and chalazion', 75, 9),
(129, 'Urticaria, unspecified', 76, 9),
(130, 'Allergic contact dermatitis, unspecified cause', 77, 9),
(131, 'Non-insulin-dependent diabetes mellitus with multiple complications', 78, 9),
(132, 'Acute laryngopharyngitis', 79, 9),
(133, 'Cervicocranial syndrome', 80, 9),
(134, 'Cutaneous abscess,', 81, 9),
(135, 'Neoplasm of uncertain or unknown behavior of testis', 82, 9),
(136, 'Stroke, not specified as haemorrhage or infarction', 83, 9),
(137, 'Gout', 84, 9),
(138, 'Fever of other and unknown origin', 85, 9),
(139, 'Headache', 86, 9),
(140, 'Other specified surgical follow-up care', 87, 9),
(141, 'Nonsuppurative otitis', 88, 9),
(142, 'Anosmia', 89, 9),
(143, 'Presbyopia', 90, 9),
(144, 'Excessive, frequent and irregular menstruation', 91, 9),
(145, 'Acute bronchitis, unspecified', 92, 9),
(146, 'Epidemic vertigo', 93, 9),
(147, 'Anorexia', 94, 9),
(148, 'Superficial injury of head, part unspecified', 95, 9),
(149, 'Irritable bowel syndrome', 96, 9),
(150, 'Acute bronchitis', 97, 9),
(151, 'Impacted cerumen', 98, 9),
(152, 'Unspecified contact dermatitis', 99, 9),
(153, 'Gastritis and duodenitis', 100, 9),
(154, 'Disorder of lacrimal system, unspecified', 101, 9),
(155, 'Redundant prepuce, phimosis and paraphimosis', 102, 9),
(156, 'Insulin-dependent diabetes mellitus with renal complications', 103, 9),
(157, 'Acute pharyngitis', 104, 9),
(158, 'Essential (primary)', 105, 9),
(159, 'Cervical disc disorders', 106, 9),
(160, 'Cardiomegaly', 107, 9),
(161, 'Pyoderma', 108, 9),
(162, 'Other benign neoplasm of connective and other soft tissue of head, face and neck', 109, 9),
(163, 'Fracture of clavicle', 110, 9),
(164, 'Myalgia', 111, 9),
(165, 'Urticaria', 112, 9),
(166, 'Influenza with pneumonia, influenza virus identified', 113, 9),
(167, 'Malignant neoplasm of ovary', 114, 9),
(168, 'Cutaneous abscess, furuncle and carbuncle of other sites', 115, 9),
(169, 'Unspecified renal colic', 116, 9),
(170, 'Other headache', 117, 9),
(171, 'Tuberculous peripheral', 118, 9),
(172, 'Chronic obstructive', 119, 9),
(173, 'Superficial injury of lower leg, unspecified', 120, 9),
(174, 'Mucopurulent conjunctivitis', 121, 9),
(175, 'Chronic post-traumatic headache', 122, 9),
(176, 'Cercarial dermatitis', 123, 9),
(177, 'Tinnitus', 124, 9),
(178, 'Hypertrophy of tonsils with hypertrophy of adenoids', 125, 9),
(179, 'Febrile convulsions', 126, 9),
(180, 'Scabies', 127, 9),
(181, 'Low back pain', 128, 9),
(182, 'Irritant contact dermatitis', 129, 9),
(183, 'Non-insulin-dependent diabetes mellitus with unspecified complications', 130, 9),
(184, 'Vertigo of central origin', 131, 9),
(185, 'Visual impairment', 132, 9),
(186, 'Conjunctivitis', 133, 9),
(187, 'Hyphaema', 134, 9),
(188, 'Panniculitis affecting', 135, 9),
(189, 'Disorder of urinary system, unspecified', 136, 9),
(190, 'Mucopurulent', 137, 9),
(191, 'Follow-up examination after other treatment for other conditions', 138, 9),
(192, 'Hypotension', 139, 9),
(193, 'Otitis externa, unspecified', 140, 9),
(194, 'Benign neoplasm of unspecified site', 141, 9),
(195, 'Other specified symptoms and signs involving the digestive system and abdomen', 142, 9),
(196, 'Chronic kidney disease', 143, 9),
(197, 'Cutaneous abscess, furuncle and carbuncle', 144, 9),
(198, 'Other arthrosis', 145, 9),
(199, 'Panniculitis affecting regions of neck and back, lumbar region', 146, 9),
(200, 'Tinea cruris', 147, 9),
(201, 'Cough', 148, 9),
(202, 'Chronic renal failure, unspecified', 149, 9),
(203, 'Gastroduodenitis,', 150, 9),
(204, 'Tuberculosis of lung, confirmed by sputum microscopy with or without culture', 151, 9),
(205, 'Typhoid and paratyphoid fevers', 152, 9),
(206, 'Hydrocephalus, unspecified', 153, 9),
(207, 'Cleft palate with cleft lip', 154, 9),
(208, 'Hyperlipidaemia, unspecified', 155, 9),
(209, 'Vaginitis, vulvitis and vulvovaginitis in infectious and parasitic diseases classified elsewhere', 156, 9),
(210, 'Insulin-dependent diabetes mellitus', 157, 9),
(211, 'Streptococcal pharyngitis', 158, 9),
(212, 'Benign neoplasm of other and unspecified sites', 159, 9),
(213, 'Conjunctivitis, unspecified', 160, 9),
(214, 'Brachial plexus disorders', 161, 9),
(215, 'Angina pectoris', 162, 9),
(216, 'Other disorders of conjunctiva', 163, 9),
(217, 'Follicular cyst of skin and subcutaneous tissue, unspecified', 164, 9),
(218, 'Superficial injury of hip and thigh, unspecified', 165, 9),
(219, 'Benign neoplasm of breast', 166, 9),
(220, 'Asthma, unspecified', 167, 9),
(221, 'Miliaria rubra', 168, 9),
(222, 'Mastodynia', 169, 9),
(223, 'Malignant neoplasm of breast', 170, 9),
(224, 'Amenorrhoea, unspecified', 171, 9),
(225, 'Supervision of high-risk pregnancy, unspecified', 172, 9),
(226, 'Acute appendicitis, unspecified', 173, 9),
(227, 'Neonatal jaundice, unspecified', 174, 9),
(228, 'Cutaneous abscess, furuncle and carbuncle, unspecified', 175, 9),
(229, 'Excessive and frequent menstruation with regular cycle', 176, 9),
(230, 'Other gastritis', 177, 9),
(231, 'Routine child health examination', 178, 9),
(232, 'Dorsalgia', 179, 9),
(233, 'Contraceptive management', 180, 9),
(234, 'Epilepsy, unspecified', 181, 9),
(235, 'Radiculopathy, lumbar', 182, 9),
(236, 'Schizophrenia', 183, 9),
(237, 'Heart failure', 184, 9),
(238, 'Other rheumatic heart diseases', 185, 9),
(239, 'Gingival recession', 186, 9),
(240, 'Senile nuclear cataract', 187, 9),
(241, 'Atrial fibrillation and flutter', 188, 9),
(242, 'Asthma', 189, 9),
(243, 'Myopia', 190, 9),
(244, 'Neoplasm of uncertain or unknown behavior of breast', 191, 9),
(245, 'Pain in thoracic spine', 192, 9),
(246, 'Acute tracheitis', 193, 9),
(247, 'Other specified headache syndromes', 194, 9),
(248, 'Excessive and frequent menstruation with irregular cycle', 195, 9),
(249, 'Acute sinusitis', 196, 9),
(250, 'Otitis media, unspecified', 197, 9),
(251, 'Respiratory tuberculosis, bacteriologically and histologically confirmed', 198, 9),
(252, 'Panniculitis affecting regions of neck and back, thoracic region', 199, 9),
(253, 'Follow-up examination\nafter unspecified treatment for other conditions', 200, 9),
(254, 'Influenza, virus not identified', 201, 9),
(255, 'Superficial injury of abdomen, lower back and pelvis, part unspecified', 202, 9),
(256, 'Keratitis', 203, 9),
(257, 'Epistaxis', 204, 9),
(258, 'Peptic ulcer, site unspecified', 205, 9),
(259, 'Other allergic rhinitis', 206, 9),
(260, 'Pityriasis versicolor', 207, 9),
(261, 'Alopecia areata', 208, 9),
(262, 'Personal history of medical treatment', 209, 9),
(263, 'Parkinson\'s disease', 210, 9),
(264, 'Enlarged lymph nodes, unspecified', 211, 9),
(265, 'Radiculopathy, lumbar region', 212, 9),
(266, 'Ascariasis, unspecified', 213, 9),
(267, 'Acute prostatitis', 214, 9),
(268, 'Nausea and vomiting', 215, 9),
(269, 'Intervertebral disc', 216, 9),
(270, 'Tinea manuum', 217, 9),
(271, 'Varicella [chickenpox]', 218, 9),
(272, 'Mumps', 219, 9),
(273, 'Polyarthritis, unspecified', 220, 9),
(274, 'Inguinal hernia', 221, 9),
(275, 'Dextrocardia', 222, 9),
(276, 'Absent, scanty and rare menstruation', 223, 9),
(277, 'Disorders of meninges, not elsewhere classified', 224, 9),
(278, 'Hyperplasia of prostate', 225, 9),
(279, 'Burns classified according to extent of body surface involved', 226, 9),
(280, 'Atherosclerotic heart', 227, 9),
(281, 'Viral warts', 228, 9),
(282, 'Unspecified haemorrhoids', 229, 9),
(283, 'Calculus of kidney and ureter', 230, 9),
(284, 'Supervision of normal pregnancy, unspecified', 231, 9),
(285, 'Unspecified haemorrhoids with other complications', 232, 9),
(286, 'Measles', 233, 9),
(287, 'Impacted teeth', 234, 9),
(288, 'Down syndrome', 235, 9),
(289, 'Sleep disorder,', 236, 9),
(290, 'Cerebral infarction,', 237, 9),
(291, 'Other benign neoplasm of connective and other soft tissue of thorax Axilla', 238, 9),
(292, 'Low vision, one eye', 239, 9),
(293, 'Acute ischaemic heart disease, unspecified', 240, 9),
(294, 'Observation for suspected disease or condition, unspecified', 241, 9),
(295, 'Examination and', 242, 9),
(296, 'Other nonorganic', 243, 9),
(297, 'Inflammatory disorders of breast', 244, 9),
(298, 'Other soft tissue disorders, not elsewhere classified', 245, 9),
(299, 'Malignant neoplasm of cervix uteri', 246, 9),
(300, 'Other chronic obstructive pulmonary disease', 247, 9),
(301, 'Whooping cough, unspecified', 248, 9),
(302, 'Cutaneous abscess, furuncle and carbuncle of buttock', 249, 9),
(303, 'Acute lymphadenitis of upper limb', 250, 9),
(304, 'Unspecified diabetes mellitus with peripheral circulatory complications', 251, 9),
(305, 'Follow-up examination after treatment of fracture', 252, 9),
(306, 'Sprain and strain of other and unspecified parts of foot', 253, 9),
(307, 'Disease of upper respiratory tract, unspecified', 254, 9),
(308, 'Foreign body in ear', 255, 9),
(309, 'Acute nephritic syndrome, unspecified', 256, 9),
(310, 'Malignant neoplasm of bronchus and lung', 257, 9),
(311, 'Corns and callosities', 258, 9),
(312, 'Thyrotoxicosis', 259, 9),
(313, 'Tension-type headache', 260, 9),
(314, 'Premature rupture of membranes, unspecified', 261, 9),
(315, 'Candidiasis of vulva and vagina', 262, 9),
(316, 'Disorder of thyroid, unspecified', 263, 9),
(317, 'Herpesviral [herpes]', 264, 9),
(318, 'Bronchopneumonia, unspecified', 265, 9),
(319, 'Acute periodontitis', 266, 9),
(320, 'Gastro-oesophageal reflux disease', 267, 9),
(321, 'Other specified diseases of upper respiratory tract', 268, 9),
(322, 'Paraplegia, unspecified', 269, 9),
(323, 'Candidiasis, unspecified', 270, 9),
(324, 'Cystitis', 271, 9),
(325, 'Candidiasis', 272, 9),
(326, 'Need for immunization against single bacterial diseases', 273, 9),
(327, 'Diarrhoea and', 274, 9),
(328, 'Constipation', 275, 9),
(329, 'Pulmonary heart disease, unspecified', 276, 9),
(330, 'Idiopathic gout', 277, 9),
(331, 'Nutritional deficiency, unspecified', 278, 9),
(332, 'Abdominal and pelvic pain', 279, 9),
(333, 'Mononeuropathy, unspecified', 280, 9),
(334, 'Single spontaneous delivery, unspecified', 281, 9),
(335, 'Other superficial injuries of eyelid and periocular area', 282, 9),
(336, 'Haemoptysis', 283, 9),
(337, 'Dysphagia', 284, 9),
(338, 'Acute myocardial', 285, 9),
(339, 'Malignant neoplasm of pancreas', 286, 9),
(340, 'Receptive language disorder', 287, 9),
(341, 'Hearing loss, unspecified', 288, 9),
(342, 'Injury of eye and orbit', 289, 9),
(343, 'Caries of dentine', 290, 9),
(344, 'Seropositive rheumatoid arthritis', 291, 9),
(345, 'Malaise and fatigue', 292, 9),
(346, 'Hordeolum and other deep inflammation of eyelid', 293, 9),
(347, 'Tuberculous meningitis', 294, 9),
(348, 'Osteopathies in diseases classified elsewhere', 295, 9),
(349, 'Erosive (osteo)arthrosis', 296, 9),
(350, 'Systemic lupus', 297, 9),
(351, 'Dermatophytosis,', 298, 9),
(352, 'Other disorders of central nervous system', 299, 9),
(353, 'Blepharitis', 300, 9),
(354, 'Other chronic suppurative otitis media', 301, 9),
(355, 'Respiratory tuberculosis,', 302, 9),
(356, 'Malignant neoplasm of breast, unspecified', 303, 9),
(357, 'Ulcerative colitis', 304, 9),
(358, 'Insulin-dependent', 305, 9),
(359, 'Irritant contact dermatitis, unspecified cause', 306, 9),
(360, 'Toxic effect of venom of scorpion', 307, 9),
(361, 'Malignant neoplasm of bone and articular cartilage of other and unspecified sites', 308, 9),
(362, 'Faecal incontinence', 309, 9),
(363, 'General examination and investigation of persons without complaint and reported diagnosis', 310, 9),
(364, 'Gonarthrosis, unspecified', 311, 9),
(365, 'Foreign body in stomach', 312, 9),
(366, 'Idiopathic', 313, 9),
(367, 'Spontaneous vertex', 314, 9),
(368, 'Allergic rhinitis, unspecified', 315, 9),
(369, 'Spontaneous vertex delivery', 316, 9),
(370, 'Migraine', 317, 9),
(371, 'Internal thrombosed haemorrhoids', 318, 9),
(372, 'Other dermatophytoses', 319, 9),
(373, 'Tinea nigra', 320, 9),
(374, 'Other diseases of upper respiratory tract', 321, 9),
(375, 'Mastoiditis and related conditions', 322, 9),
(376, 'Keratitis, unspecified', 323, 9),
(377, 'External thrombosed haemorrhoids', 324, 9),
(378, 'Chronic tonsillitis', 325, 9),
(379, 'Gastrointestinal haemorrhage, unspecified', 326, 9),
(380, 'Acute sinusitis, unspecified', 327, 9),
(381, 'Fibroadenosis of breast', 328, 9),
(382, 'Cervical disc disorder, unspecified', 329, 9),
(383, 'Thyrotoxicosis, unspecified', 330, 9),
(384, 'Melaena', 331, 9),
(385, 'Arthrosis of first carpometacarpal joint, unspecified', 332, 9),
(386, 'Disruption of caesarean section wound', 333, 9),
(387, 'Tetralogy of Fallot', 334, 9),
(388, 'Hyperemesis gravidarum', 335, 9),
(389, 'Molluscum contagiosum', 336, 9),
(390, 'Premature rupture of membranes', 337, 9),
(391, 'Unspecified injury of head', 338, 9),
(392, 'Unilateral or unspecified inguinal hernia, without obstruction or gangrene', 339, 9),
(393, 'Benign lipomatous neoplasm', 340, 9),
(394, 'After-cataract', 341, 9),
(395, 'Allergic contact dermatitis', 342, 9),
(396, 'Other disorders of urinary system', 343, 9),
(397, 'Benign mammary dysplasia', 344, 9),
(398, 'Panniculitis affecting regions of neck and back, thoracolumbar region', 345, 9),
(399, 'Nephrotic syndrome', 346, 9),
(400, 'Benign paroxysmal vertigo', 347, 9),
(401, 'Blepharoconjunctivitis', 348, 9),
(402, 'Calculus of kidney', 349, 9),
(403, 'General medical', 350, 9),
(404, 'Lymphoid leukaemia,', 351, 9),
(405, 'Inflammatory disease of uterus, except cervix', 352, 9),
(406, 'Acute stress reaction', 353, 9),
(407, 'Crohn disease [regional enteritis]', 354, 9),
(408, 'Thalassaemia', 355, 9),
(409, 'Seborrhoeic dermatitis', 356, 9),
(410, 'Otitis externa', 357, 9),
(411, 'Superficial injury of forearm', 358, 9),
(412, 'Other dermatitis', 359, 9),
(413, 'Chromosome replaced with ring or dicentric', 360, 9),
(414, 'Shigellosis due to Shigella dysenteriae', 361, 9),
(415, 'Congenital malformation of heart, unspecified', 362, 9),
(416, 'Other prurigo', 363, 9),
(417, 'Panniculitis affecting regions of neck and back, lumbosacral region', 364, 9),
(418, 'Benign neoplasm of thyroid gland', 365, 9),
(419, 'Unspecified viral hepatitis', 366, 9),
(420, 'Single spontaneous', 367, 9),
(421, 'Chronic mucoid otitis media', 368, 9),
(422, 'Follow-up care involving removal of fracture plate and other internal fixation device', 369, 9),
(423, 'Burn and corrosion, body region unspecified', 370, 9),
(424, 'Influenza due to identified avian infliuenza virus', 371, 9),
(425, 'Disease of intestine, unspecified', 372, 9),
(426, 'Unstable angina', 373, 9),
(427, 'Acute gingivitis', 374, 9),
(428, 'Tinea barbae and tinea capitis', 375, 9),
(429, 'Gout, unspecified', 376, 9),
(430, 'Beta thalassaemia', 377, 9),
(431, 'Superficial injury of shoulder and upper arm, unspecified', 378, 9),
(432, 'Extremely low birth weight', 379, 9),
(433, 'Tuberculosis of lung, confirmed by culture only', 380, 9),
(434, 'Other inflammation of eyelid', 381, 9),
(435, 'Abnormalities of size and form of teeth', 382, 9),
(436, 'Lumbar and other intervertebral disc disorders with radiculopathy', 383, 9),
(437, 'Ankylosing spondylitis', 384, 9),
(438, 'Chronic viral hepatitis, unspecified', 385, 9),
(439, 'Herpesviral [herpes simplex] infections', 386, 9),
(440, 'Sleep disorders', 387, 9),
(441, 'Other specified intervertebral disc disorders', 388, 9),
(442, 'Other follicular disorders', 389, 9),
(443, 'Trigger finger', 390, 9),
(444, 'Disorders of sphingolipid metabolism and other lipid storage disorders', 391, 9),
(445, 'Noninflammatory disorders of ovary, fallopian tube\nand broad ligament', 392, 9),
(446, 'Other forms of angina pectoris', 393, 9),
(447, 'Transient cerebral ischaemic attack, unspecified', 394, 9),
(448, 'Osteoporosis with pathological fracture', 395, 9),
(449, 'Other general examinations', 396, 9),
(450, 'Traumatic amputation of ankle and foot', 397, 9),
(451, 'Other osteoporosis', 398, 9),
(452, 'Hydrocephalus', 399, 9),
(453, 'Fibrosis and cirrhosis of liver', 400, 9),
(454, 'Excessive attrition of teeth', 401, 9),
(455, 'Cleft soft palate with bilateral cleft lip', 402, 9),
(456, 'Secondary and unspecified malignant neoplasm of lymph nodes', 403, 9),
(457, 'Uterovaginal prolapse,', 404, 9),
(458, 'Urinary calculus,', 405, 9),
(459, 'Noninflammatory disorder', 406, 9),
(460, 'Haemorrhage from', 407, 9),
(461, 'Foreign body in mouth', 408, 9),
(462, 'Allergic rhinitis,', 409, 9),
(463, 'Pyoderma gangrenosum', 410, 9),
(464, 'Nonorganic insomnia', 411, 9),
(465, 'Other benign neoplasm of connective and other soft tissue of lower limb, including hip', 412, 9),
(466, 'Other acne', 413, 9),
(467, 'Tuberculosis of lung, confirmed histologically', 414, 9),
(468, 'Chronic serous otitis media', 415, 9),
(469, 'Low back pain, cervical region', 416, 9),
(470, 'Acute pancreatitis', 417, 9),
(471, 'Disorders related to short gestation and low birth weight, not elsewhere classified', 418, 9),
(472, 'Disorder of facial nerve, unspecified', 419, 9),
(473, 'Other headache syndromes', 420, 9),
(474, 'Uterovaginal prolapse, unspecified', 421, 9),
(475, 'Routine and ritual circumcision', 422, 9),
(476, 'Hypothermia of newborn, unspecified', 423, 9),
(477, 'Calculus of ureter', 424, 9),
(478, 'Anaemia, unspecified', 425, 9),
(479, 'Gastrointestinal tularaemia', 426, 9),
(480, 'Unspecified renal failure', 427, 9),
(481, 'Other appendicitis', 428, 9),
(482, 'Acute renal failure, unspecified', 429, 9),
(483, 'Non-insulin-dependent diabetes mellitus with coma', 430, 9),
(484, 'Gastric ulcer, chronic without haemorrhage or perforation', 432, 9),
(485, 'Rabies', 433, 9),
(491, 'Ujung Batu, Rokan Hulu, Riau, Indonesia', 1, 10),
(492, 'Ngaso, 28554, Ujung Batu, Rokan Hulu, Riau, Indonesia', 2, 10),
(493, 'Ujung Batu Timur, 28554, Ujung Batu, Rokan Hulu, Riau, Indonesia', 3, 10),
(494, 'Pematang Tebih, 28554, Ujung Batu, Rokan Hulu, Riau, Indonesia', 4, 10),
(495, 'Suka Damai, 28554, Ujung Batu, Rokan Hulu, Riau, Indonesia', 5, 10),
(496, 'other disorders of penis', 434, 9),
(497, 'Pegawai', 15, 7),
(498, 'bell\'s palsy', 435, 9),
(499, 'unspecified jaundice', 436, 9),
(500, 'other specified chronic obstructive pulmonary disease', 437, 9),
(501, 'follow-up examination after treatment for malignant neoplasm', 438, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `instansi_konfigurasi` varchar(200) NOT NULL,
  `nama_konfigurasi` varchar(200) NOT NULL,
  `nohp_konfigurasi` varchar(25) NOT NULL,
  `alamat_konfigurasi` text NOT NULL,
  `email_konfigurasi` varchar(100) NOT NULL,
  `gambar_konfigurasi` varchar(300) NOT NULL,
  `copyright_konfigurasi` varchar(200) NOT NULL,
  `tentang_konfigurasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `instansi_konfigurasi`, `nama_konfigurasi`, `nohp_konfigurasi`, `alamat_konfigurasi`, `email_konfigurasi`, `gambar_konfigurasi`, `copyright_konfigurasi`, `tentang_konfigurasi`) VALUES
(1, 'Kantor Wilayah Programmer', 'Klarifikasi Surat Metode Naive Bayes', '082277506232', 'Alamat instansi gue bro', 'bimaega15@gmail.com', '537791656104026SuratKeteranganBebas.png', 'Bima Ega Fullstack Developer', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum labore perspiciatis reiciendis dolore doloremque cupiditate ipsum dolorem ducimus mollitia natus pariatur quaerat deserunt aperiam dignissimos eveniet facere ratione, nam, assumenda facilis a enim rem deleniti. Sit, omnis nobis eius, voluptate quasi ab facere saepe corrupti aliquam consectetur quibusdam quaerat quia voluptatibus distinctio dignissimos commodi quis odio esse sequi aperiam! Incidunt dignissimos illum magnam eum cupiditate? Minus facilis et culpa dicta vero nemo tempore voluptatum sit magni inventore, deserunt, facere sequi!</p>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(11) NOT NULL,
  `nama_profile` varchar(200) NOT NULL,
  `alamat_profile` text NOT NULL,
  `nohp_profile` varchar(20) NOT NULL,
  `jenis_kelamin_profile` enum('L','P') NOT NULL,
  `gambar_profile` varchar(200) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id_profile`, `nama_profile`, `alamat_profile`, `nohp_profile`, `jenis_kelamin_profile`, `gambar_profile`, `users_id`) VALUES
(1, 'Rahayu', 'My alamat', '0938247289', 'P', '690351656104017PemindahBukuan.png', 1),
(5, 'admin124', 'admin124', '32523532', 'L', '579501655485994PemindahBukuan.png', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('admin','users') NOT NULL,
  `cookie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `level`, `cookie`) VALUES
(1, 'admin123', '0192023a7bbd73250516f069df18b500', 'admin', 0),
(5, 'admin124', 'd325ffe191a600f562fb59ae52ccbc75', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `coordinate`
--
ALTER TABLE `coordinate`
  ADD PRIMARY KEY (`id_coordinate`),
  ADD KEY `inisialisasi_detail_id` (`inisialisasi_detail_id`);

--
-- Indeks untuk tabel `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id_dataset`);

--
-- Indeks untuk tabel `dataset_detail`
--
ALTER TABLE `dataset_detail`
  ADD PRIMARY KEY (`id_dataset_detail`),
  ADD KEY `dataset_detail_ibfk_2` (`inisialisasi_id`),
  ADD KEY `inisialisasi_detail_id` (`inisialisasi_detail_id`),
  ADD KEY `dataset_detail_ibfk_1` (`dataset_id`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `hasil_detail`
--
ALTER TABLE `hasil_detail`
  ADD PRIMARY KEY (`id_hasil_detail`),
  ADD KEY `hasil_id` (`hasil_id`),
  ADD KEY `dataset_id` (`dataset_id`);

--
-- Indeks untuk tabel `inisialisasi`
--
ALTER TABLE `inisialisasi`
  ADD PRIMARY KEY (`id_inisialisasi`);

--
-- Indeks untuk tabel `inisialisasi_detail`
--
ALTER TABLE `inisialisasi_detail`
  ADD PRIMARY KEY (`id_inisialisasi_detail`),
  ADD KEY `diagnosa_id` (`inisialisasi_id`);

--
-- Indeks untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indeks untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `coordinate`
--
ALTER TABLE `coordinate`
  MODIFY `id_coordinate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id_dataset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3974;

--
-- AUTO_INCREMENT untuk tabel `dataset_detail`
--
ALTER TABLE `dataset_detail`
  MODIFY `id_dataset_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19866;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `hasil_detail`
--
ALTER TABLE `hasil_detail`
  MODIFY `id_hasil_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4034;

--
-- AUTO_INCREMENT untuk tabel `inisialisasi`
--
ALTER TABLE `inisialisasi`
  MODIFY `id_inisialisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `inisialisasi_detail`
--
ALTER TABLE `inisialisasi_detail`
  MODIFY `id_inisialisasi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=506;

--
-- AUTO_INCREMENT untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `coordinate`
--
ALTER TABLE `coordinate`
  ADD CONSTRAINT `coordinate_ibfk_1` FOREIGN KEY (`inisialisasi_detail_id`) REFERENCES `inisialisasi_detail` (`id_inisialisasi_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dataset_detail`
--
ALTER TABLE `dataset_detail`
  ADD CONSTRAINT `dataset_detail_ibfk_1` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id_dataset`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dataset_detail_ibfk_2` FOREIGN KEY (`inisialisasi_id`) REFERENCES `inisialisasi` (`id_inisialisasi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dataset_detail_ibfk_3` FOREIGN KEY (`inisialisasi_detail_id`) REFERENCES `inisialisasi_detail` (`id_inisialisasi_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_detail`
--
ALTER TABLE `hasil_detail`
  ADD CONSTRAINT `hasil_detail_ibfk_1` FOREIGN KEY (`hasil_id`) REFERENCES `hasil` (`id_hasil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_detail_ibfk_2` FOREIGN KEY (`dataset_id`) REFERENCES `dataset` (`id_dataset`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `inisialisasi_detail`
--
ALTER TABLE `inisialisasi_detail`
  ADD CONSTRAINT `inisialisasi_detail_ibfk_1` FOREIGN KEY (`inisialisasi_id`) REFERENCES `inisialisasi` (`id_inisialisasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
