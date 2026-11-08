-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2026 at 09:52 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alur_kas`
--

-- --------------------------------------------------------

--
-- Table structure for table `alur_kas`
--

CREATE TABLE `alur_kas` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `no_kas_number` int(11) DEFAULT 0,
  `no_kas_number_formatted` varchar(50) DEFAULT '',
  `no_referensi` varchar(100) DEFAULT '-',
  `tanggal` datetime DEFAULT NULL,
  `jumlah_masuk` double(10,2) DEFAULT 0.00,
  `jumlah_keluar` double(10,2) DEFAULT 0.00,
  `alur_kas` varchar(1) NOT NULL,
  `keterangan` varchar(200) DEFAULT '-',
  `tabungan_id` int(11) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT 0,
  `transfer_id` int(11) DEFAULT 0,
  `hutang_id` int(11) DEFAULT 0,
  `pelunasan_hutang_id` int(11) DEFAULT 0,
  `piutang_id` int(11) DEFAULT 0,
  `pelunasan_piutang_id` int(11) DEFAULT 0,
  `is_deleted` varchar(1) DEFAULT '0',
  `is_deleted_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted_memo` varchar(200) DEFAULT '',
  `modified` datetime DEFAULT NULL,
  `modifier_user_id` int(11) DEFAULT 0,
  `modifier_user_name` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alur_kas`
--

INSERT INTO `alur_kas` (`id`, `created`, `creator_user_id`, `creator_user_name`, `no_kas_number`, `no_kas_number_formatted`, `no_referensi`, `tanggal`, `jumlah_masuk`, `jumlah_keluar`, `alur_kas`, `keterangan`, `tabungan_id`, `kategori_id`, `transfer_id`, `hutang_id`, `pelunasan_hutang_id`, `piutang_id`, `pelunasan_piutang_id`, `is_deleted`, `is_deleted_date`, `is_deleted_memo`, `modified`, `modifier_user_id`, `modifier_user_name`) VALUES
(65, '2020-01-27 07:28:35', 17, 'Demo', 1, 'AK/M/20/01/000001', '123514', '2020-01-27 00:00:00', 99999999.99, 0.00, '1', 'TRF BARU', 26, 18, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-02-10 23:37:23', 17, 'Demo'),
(67, '2020-01-27 08:18:58', 17, 'Demo', 3, 'AK/K/20/01/000003', '123', '2020-01-28 00:00:00', 0.00, 2000000.00, '0', 'SANDI', 26, 19, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-01-27 15:18:58', 17, 'Demo'),
(71, '2020-04-26 05:20:46', 17, 'Demo', 7, 'AK/K/20/04/000007', '123456', '2020-04-26 00:00:00', 0.00, 1000000.00, '0', 'gajih', 26, 19, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:20:46', 17, 'Demo'),
(72, '2020-04-26 05:21:31', 17, 'Demo', 8, 'AK/K/20/04/000008', '123456789', '2020-04-26 00:00:00', 0.00, 1000000.00, '0', 'gajih', 26, 19, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:21:31', 17, 'Demo'),
(73, '2020-04-26 05:21:52', 17, 'Demo', 9, 'AK/M/20/04/000009', '123456', '2020-04-26 00:00:00', 5000000.00, 0.00, '1', 'saldo', 26, 18, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:21:52', 17, 'Demo'),
(74, '2020-04-26 05:23:38', 17, 'Demo', 10, 'AK/K/20/04/000010', 'TF/2020/04/000001', '2020-04-26 00:00:00', 0.00, 1000000.00, '0', 'pindah', 26, 0, 1, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:23:38', 17, 'Demo'),
(75, '2020-04-26 05:23:38', 17, 'Demo', 11, 'AK/M/20/04/000011', 'TF/2020/04/000001', '2020-04-26 00:00:00', 1000000.00, 0.00, '1', 'pindah', 27, 0, 1, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:23:38', 17, 'Demo'),
(76, '2020-04-26 05:24:40', 17, 'Demo', 12, 'AK/K/20/04/000012', 'TF/2020/04/000002', '2020-04-26 00:00:00', 0.00, 19000000.00, '0', 'pindah', 26, 0, 2, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:24:41', 17, 'Demo'),
(77, '2020-04-26 05:24:40', 17, 'Demo', 13, 'AK/M/20/04/000013', 'TF/2020/04/000002', '2020-04-26 00:00:00', 19000000.00, 0.00, '1', 'pindah', 27, 0, 2, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:24:41', 17, 'Demo'),
(78, '2020-04-26 05:25:22', 17, 'Demo', 14, 'AK/K/20/04/000014', 'TF/2020/04/000003', '2020-04-26 00:00:00', 0.00, 5000000.00, '0', 'pindah', 26, 0, 3, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:25:22', 17, 'Demo'),
(79, '2020-04-26 05:25:22', 17, 'Demo', 15, 'AK/M/20/04/000015', 'TF/2020/04/000003', '2020-04-26 00:00:00', 5000000.00, 0.00, '1', 'pindah', 27, 0, 3, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:25:22', 17, 'Demo'),
(80, '2020-04-26 05:31:17', 17, 'Demo', 16, 'AK/M/20/04/000016', '123456', '2020-04-26 00:00:00', 15000000.00, 0.00, '1', 'gajih', 27, 19, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:32:47', 17, 'Demo'),
(81, '2020-06-20 02:32:06', 17, 'Demo', 17, 'AK/M/20/06/000017', '', '2020-06-01 00:00:00', 5000000.00, 0.00, '1', 'asd', 26, 18, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-06-20 09:32:06', 17, 'Demo'),
(83, '2020-08-05 06:05:38', 17, 'Demo', 19, 'AK/K/20/08/000019', 'TF/2020/08/000004', '2020-08-05 00:00:00', 0.00, 3000.00, '0', '', 27, 0, 4, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-08-05 13:05:38', 17, 'Demo'),
(84, '2020-08-05 06:05:38', 17, 'Demo', 20, 'AK/M/20/08/000020', 'TF/2020/08/000004', '2020-08-05 00:00:00', 3000.00, 0.00, '1', '', 26, 0, 4, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-08-05 13:05:38', 17, 'Demo'),
(85, '2020-08-05 08:58:53', 17, 'Demo', 21, 'AK/M/20/08/000021', '', '2020-08-05 00:00:00', 1000000.00, 0.00, '1', 'Hasil usaha', 28, 18, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-08-05 15:58:53', 17, 'Demo'),
(88, '2020-12-29 14:57:35', 1, 'Super Administrator', 24, 'AK/M/20/12/000024', '', '2020-12-29 00:00:00', 50000.00, 0.00, '1', 'asd', 26, 18, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2020-12-29 22:57:35', 1, 'Super Administrator'),
(89, '2026-07-30 06:37:39', 26, 'Jika Aura Jati', 25, 'AK/M/26/07/000025', '', '2026-07-30 00:00:00', 25000000.00, 0.00, '1', 'dana koperasi sekolah', 26, 18, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2026-07-30 15:37:39', 26, 'Jika Aura Jati'),
(91, '2026-07-30 07:22:14', 26, 'Jika Aura Jati', 26, 'AK/K/26/07/000026', '', '2026-07-30 00:00:00', 0.00, 3000000.00, '0', 'bayar gaji tukang bersih', 26, 19, 0, 0, 0, 0, 0, '0', '0000-00-00 00:00:00', '', '2026-07-30 16:22:14', 26, 'Jika Aura Jati');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `nama` varchar(50) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT '',
  `alur_kas` varchar(20) DEFAULT 'MASUK',
  `modified` datetime DEFAULT NULL,
  `modifier_user_id` int(11) DEFAULT 0,
  `modifier_user_name` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `created`, `creator_user_id`, `creator_user_name`, `nama`, `keterangan`, `alur_kas`, `modified`, `modifier_user_id`, `modifier_user_name`) VALUES
(18, '2020-01-27 07:28:07', 17, 'Demo', 'TAMBAH SALDO', 'TRF SALDO', 'MASUK', '2020-01-27 14:28:07', 17, 'Demo'),
(19, '2020-01-27 07:29:57', 17, 'Demo', 'GAJIH', NULL, 'KELUAR', '2020-09-01 17:57:43', 17, 'Demo'),
(20, '2020-01-31 01:22:53', 17, 'Demo', 'PARKIR', 'PASAR CIWIDEY', 'KELUAR', '2020-01-31 08:22:53', 17, 'Demo'),
(21, '2020-04-26 05:19:04', 17, 'Demo', 'KAMAR', 'RENOVASI', 'KELUAR', '2020-04-26 12:39:14', 21, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tabungan`
--

CREATE TABLE `tabungan` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `nama` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifier_user_id` int(11) DEFAULT 0,
  `modifier_user_name` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabungan`
--

INSERT INTO `tabungan` (`id`, `created`, `creator_user_id`, `creator_user_name`, `nama`, `keterangan`, `modified`, `modifier_user_id`, `modifier_user_name`) VALUES
(26, '2020-01-27 07:26:31', 17, 'Demo', 'BANK BCA', '132002000yy', '2020-06-22 10:30:50', 17, 'Demo'),
(27, '2020-01-27 07:26:46', 17, 'Demo', 'BANK BRI', '0161000', '2020-01-27 14:26:46', 17, 'Demo'),
(28, '2020-01-31 01:19:27', 17, 'Demo', 'UANG TUNAI', '5000000000000', '2020-03-17 08:53:22', 17, 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `no_transfer_number` int(11) DEFAULT 0,
  `no_transfer_number_formatted` varchar(50) DEFAULT '',
  `no_referensi` varchar(50) DEFAULT '-',
  `tanggal` date DEFAULT NULL,
  `jumlah` double(10,2) DEFAULT NULL,
  `jumlah_fee_antar_bank` double(10,2) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `tabungan_sumber_id` int(11) DEFAULT NULL,
  `tabungan_tujuan_id` int(11) DEFAULT NULL,
  `is_deleted` varchar(1) DEFAULT '0',
  `is_deleted_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted_memo` varchar(200) DEFAULT '',
  `modified` datetime DEFAULT NULL,
  `modifier_user_id` int(11) DEFAULT 0,
  `modifier_user_name` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id`, `created`, `creator_user_id`, `creator_user_name`, `no_transfer_number`, `no_transfer_number_formatted`, `no_referensi`, `tanggal`, `jumlah`, `jumlah_fee_antar_bank`, `keterangan`, `tabungan_sumber_id`, `tabungan_tujuan_id`, `is_deleted`, `is_deleted_date`, `is_deleted_memo`, `modified`, `modifier_user_id`, `modifier_user_name`) VALUES
(1, '2020-04-26 05:23:38', 17, 'Demo', 1, 'TF/2020/04/000001', '123456', '2020-04-26', 1000000.00, NULL, 'pindah', 26, 27, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:23:38', 17, 'Demo'),
(2, '2020-04-26 05:24:40', 17, 'Demo', 2, 'TF/2020/04/000002', '123456', '2020-04-26', 19000000.00, NULL, 'pindah', 26, 27, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:24:40', 17, 'Demo'),
(3, '2020-04-26 05:25:22', 17, 'Demo', 3, 'TF/2020/04/000003', '123456', '2020-04-26', 5000000.00, NULL, 'pindah', 26, 27, '0', '0000-00-00 00:00:00', '', '2020-04-26 12:25:22', 17, 'Demo'),
(4, '2020-08-05 06:05:38', 17, 'Demo', 4, 'TF/2020/08/000004', '', '2020-08-05', 3000.00, NULL, '', 27, 26, '0', '0000-00-00 00:00:00', '', '2020-08-05 13:05:38', 17, 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) NOT NULL DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `name` varchar(100) DEFAULT '',
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_login_level_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `created`, `creator_user_id`, `creator_user_name`, `name`, `username`, `password`, `user_login_level_id`) VALUES
(1, '2018-11-18 07:43:43', 0, 'Super Administrator', 'Super Administrator', 'superadmin', '633a11aefd3255d38e92ef61707ad467', 1),
(17, '2019-10-24 22:13:39', 17, '', 'Demo', 'demo', '3eb30a92bdb166064244fd35e8b3a049', 3),
(26, '2026-07-30 06:18:43', 17, '', 'Jika Aura Jati', 'aura', '0c56b634269c10035394f1812472efc0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_level`
--

CREATE TABLE `user_login_level` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `name` varchar(100) DEFAULT '',
  `privilege_json` longtext DEFAULT NULL,
  `menu_json` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login_level`
--

INSERT INTO `user_login_level` (`id`, `created`, `creator_user_id`, `creator_user_name`, `name`, `privilege_json`, `menu_json`) VALUES
(1, '2019-01-11 14:27:48', 0, '', 'Super Administrator', '{}', '{}'),
(3, '2019-09-24 06:46:57', 1, '', 'Administrator', '{\"alur_kas\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_get_dashboard_info\":{\"label\":\" Dashboard Info\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail \\/ Edit\",\"allow\":1},\"ajax_view\":{\"label\":\" View\",\"allow\":1},\"cetak\":{\"label\":\" Cetak\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"beranda\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"root\":1},\"kategori\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"login\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"do_login\":{\"label\":\" Do Login\",\"allow\":1},\"do_logout\":{\"label\":\" Do Logout\",\"allow\":1},\"root\":1},\"tabungan\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"transfer\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail \\/ Edit\",\"allow\":1},\"ajax_view\":{\"label\":\" View\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"user_level\":{\"index\":{\"label\":\" Index\",\"allow\":0},\"ajax_list\":{\"label\":\" List\",\"allow\":0},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":0},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":0},\"ajax_save\":{\"label\":\" Save\",\"allow\":0},\"root\":0},\"user_login\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":0},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_reset_password\":{\"label\":\" Reset Password\",\"allow\":0},\"ajax_get_employee_name_for_employee_number_formatted\":{\"label\":\" Get Employee Name\",\"allow\":1},\"ajax_change_password\":{\"label\":\" User Change Password\",\"allow\":0},\"root\":0},\"user_menu\":{\"index\":{\"label\":\" Index\",\"allow\":0},\"ajax_list\":{\"label\":\" List\",\"allow\":0},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":0},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":0},\"ajax_save\":{\"label\":\" Save\",\"allow\":0},\"ajax_set_order_up\":{\"label\":\" Order Up\",\"allow\":0},\"ajax_set_order_down\":{\"label\":\" Order Down\",\"allow\":0},\"root\":0}}', '{\"80\":{\"title\":\"Beranda\",\"icon\":\"fa fa-circle-o\",\"link\":\"beranda\",\"allow\":1,\"shortcut\":0,\"child\":[]},\"77\":{\"title\":\"Transaksi\",\"icon\":\"fa fa-circle-o\",\"link\":\"\",\"allow\":1,\"shortcut\":1,\"child\":{\"84\":{\"title\":\"Alur Kas\",\"icon\":\"\",\"link\":\"alur_kas\",\"allow\":1,\"shortcut\":1},\"85\":{\"title\":\"Pindah Buku\",\"icon\":\"\",\"link\":\"transfer\",\"allow\":1,\"shortcut\":1}}},\"75\":{\"title\":\"Pengaturan\",\"icon\":\"fa fa-circle-o\",\"link\":\"\",\"allow\":1,\"shortcut\":0,\"child\":{\"82\":{\"title\":\"Kategori\",\"icon\":\"\",\"link\":\"kategori\",\"allow\":1,\"shortcut\":0},\"81\":{\"title\":\"Tabungan\",\"icon\":\"\",\"link\":\"tabungan\",\"allow\":1,\"shortcut\":0}}},\"71\":{\"title\":\"Pengguna\",\"icon\":\"fa fa-circle-o\",\"link\":\"user_login\",\"allow\":1,\"shortcut\":1,\"child\":[]}}'),
(9, '2019-09-24 06:43:46', 1, '', 'Demo', '{\"alur_kas\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_get_dashboard_info\":{\"label\":\" Dashboard Info\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail \\/ Edit\",\"allow\":1},\"ajax_view\":{\"label\":\" View\",\"allow\":1},\"cetak\":{\"label\":\" Cetak\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"beranda\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"root\":1},\"kategori\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"login\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"do_login\":{\"label\":\" Do Login\",\"allow\":1},\"do_logout\":{\"label\":\" Do Logout\",\"allow\":1},\"root\":1},\"tabungan\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"transfer\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail \\/ Edit\",\"allow\":1},\"ajax_view\":{\"label\":\" View\",\"allow\":1},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":1},\"root\":1},\"user_level\":{\"index\":{\"label\":\" Index\",\"allow\":0},\"ajax_list\":{\"label\":\" List\",\"allow\":0},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":0},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":0},\"ajax_save\":{\"label\":\" Save\",\"allow\":0},\"root\":0},\"user_login\":{\"index\":{\"label\":\" Index\",\"allow\":1},\"ajax_list\":{\"label\":\" List\",\"allow\":1},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":1},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":0},\"ajax_save\":{\"label\":\" Save\",\"allow\":1},\"ajax_reset_password\":{\"label\":\" Reset Password\",\"allow\":0},\"ajax_get_employee_name_for_employee_number_formatted\":{\"label\":\" Get Employee Name\",\"allow\":1},\"ajax_change_password\":{\"label\":\" User Change Password\",\"allow\":0},\"root\":0},\"user_menu\":{\"index\":{\"label\":\" Index\",\"allow\":0},\"ajax_list\":{\"label\":\" List\",\"allow\":0},\"ajax_detail\":{\"label\":\" Detail\",\"allow\":0},\"ajax_delete\":{\"label\":\" Delete\",\"allow\":0},\"ajax_save\":{\"label\":\" Save\",\"allow\":0},\"ajax_set_order_up\":{\"label\":\" Order Up\",\"allow\":0},\"ajax_set_order_down\":{\"label\":\" Order Down\",\"allow\":0},\"root\":0}}', '{\"80\":{\"title\":\"Beranda\",\"icon\":\"fa fa-circle-o\",\"link\":\"beranda\",\"allow\":1,\"shortcut\":1,\"child\":[]},\"77\":{\"title\":\"Transaksi\",\"icon\":\"fa fa-circle-o\",\"link\":\"\",\"allow\":1,\"shortcut\":1,\"child\":{\"84\":{\"title\":\"Alur Kas\",\"icon\":\"\",\"link\":\"alur_kas\",\"allow\":1,\"shortcut\":1},\"85\":{\"title\":\"Pindah Buku\",\"icon\":\"\",\"link\":\"transfer\",\"allow\":1,\"shortcut\":1}}},\"75\":{\"title\":\"Pengaturan\",\"icon\":\"fa fa-circle-o\",\"link\":\"\",\"allow\":1,\"shortcut\":1,\"child\":{\"82\":{\"title\":\"Kategori\",\"icon\":\"\",\"link\":\"kategori\",\"allow\":1,\"shortcut\":1},\"81\":{\"title\":\"Tabungan\",\"icon\":\"\",\"link\":\"tabungan\",\"allow\":1,\"shortcut\":1}}},\"71\":{\"title\":\"Pengguna\",\"icon\":\"fa fa-circle-o\",\"link\":\"user_login\",\"allow\":1,\"shortcut\":1,\"child\":[]}}');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_menu`
--

CREATE TABLE `user_login_menu` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_user_id` int(11) DEFAULT 0,
  `creator_user_name` varchar(100) DEFAULT '',
  `title` varchar(100) DEFAULT '',
  `icon` varchar(200) DEFAULT '',
  `link` varchar(200) DEFAULT '',
  `parent_id` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT 0,
  `is_shortcut` tinyint(1) DEFAULT 0,
  `user_login_menu_group_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login_menu`
--

INSERT INTO `user_login_menu` (`id`, `created`, `creator_user_id`, `creator_user_name`, `title`, `icon`, `link`, `parent_id`, `sort`, `is_shortcut`, `user_login_menu_group_id`) VALUES
(39, '2019-01-30 09:08:57', 1, '0', 'Recruitment &amp Termination', 'fa fa-search-plus', '', 0, 3, 0, 0),
(41, '2019-01-30 09:45:53', 1, '0', 'Test', '', 'Test', 0, 3, 0, 0),
(71, '2019-09-16 13:00:17', 1, '', 'Pengguna', 'fa fa-circle-o', 'user_login', 71, 6, 0, 0),
(75, '2019-09-16 13:00:30', 1, '', 'Pengaturan', 'fa fa-circle-o', '', 75, 5, 0, 0),
(77, '2019-09-16 12:56:19', 1, '', 'Transaksi', 'fa fa-circle-o', '', 77, 2, 0, 0),
(80, '2019-03-21 10:03:35', 1, 'Super Administrator', 'Beranda', 'fa fa-circle-o', 'beranda', 80, 1, 0, 0),
(81, '2019-09-16 12:57:39', 1, '', 'Tabungan', '', 'tabungan', 75, 2, 0, 0),
(82, '2019-09-16 12:57:30', 1, '', 'Kategori', '', 'kategori', 75, 1, 0, 0),
(84, '2019-09-16 12:56:36', 1, '', 'Alur Kas', '', 'alur_kas', 77, 1, 0, 0),
(85, '2019-09-16 12:56:50', 1, '', 'Pindah Buku', '', 'transfer', 77, 2, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alur_kas`
--
ALTER TABLE `alur_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login_level`
--
ALTER TABLE `user_login_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login_menu`
--
ALTER TABLE `user_login_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alur_kas`
--
ALTER TABLE `alur_kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tabungan`
--
ALTER TABLE `tabungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_login_level`
--
ALTER TABLE `user_login_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_login_menu`
--
ALTER TABLE `user_login_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
