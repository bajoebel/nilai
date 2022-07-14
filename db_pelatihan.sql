/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - db_pelatihan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_pelatihan` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_pelatihan`;

/*Table structure for table `hak_akses` */

DROP TABLE IF EXISTS `hak_akses`;

CREATE TABLE `hak_akses` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_level` int(11) DEFAULT NULL,
  `idx_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `hak_akses` */

insert  into `hak_akses`(`idx`,`idx_level`,`idx_menu`) values 
(1,1,1),
(2,1,2),
(3,1,3),
(4,1,4),
(5,1,5),
(6,1,6),
(7,1,7),
(8,1,8),
(9,1,9),
(10,1,10),
(11,1,11),
(12,1,12),
(13,1,13),
(14,1,14),
(15,1,15),
(16,1,16),
(17,1,17),
(18,1,18),
(19,1,19),
(20,1,20),
(21,1,21),
(22,1,22),
(23,1,23);

/*Table structure for table `hits` */

DROP TABLE IF EXISTS `hits`;

CREATE TABLE `hits` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `hits` */

insert  into `hits`(`idx`,`tgl`,`ip`,`hits`) values 
(1,'2021-09-28','127.0.0.1',14),
(2,'2021-09-29','127.0.0.1',87),
(3,'2021-09-29','::1',12),
(4,'2021-10-05','127.0.0.1',14),
(5,'2021-10-06','127.0.0.1',2),
(6,'2021-10-08','127.0.0.1',1),
(7,'2021-10-15','127.0.0.1',3),
(8,'2021-10-16','127.0.0.1',1),
(9,'2021-10-21','127.0.0.1',1),
(10,'2021-10-25','127.0.0.1',1),
(11,'2021-10-26','127.0.0.1',137),
(12,'2021-10-27','127.0.0.1',1),
(13,'2022-01-16','127.0.0.1',2),
(14,'2022-02-07','127.0.0.1',1),
(15,'2022-05-16','127.0.0.1',36),
(16,'2022-05-23','127.0.0.1',5),
(17,'2022-06-08','127.0.0.1',3),
(18,'2022-07-09','127.0.0.1',2),
(19,'2022-07-11','127.0.0.1',3);

/*Table structure for table `jenis_konten` */

DROP TABLE IF EXISTS `jenis_konten`;

CREATE TABLE `jenis_konten` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_konten` varchar(30) DEFAULT NULL,
  `jenis_url` varchar(50) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `jenis_konten` */

insert  into `jenis_konten`(`idx`,`jenis_konten`,`jenis_url`,`icon`,`aktif`) values 
(1,'Berita','berita','news.png',1),
(2,'Halaman','halaman','pages.png',1),
(3,'Pengumuman','pengumuman','pengumuman.png',1),
(4,'Agenda Kegiatan','agenda-kegiatan','agenda.png',1),
(5,'Fasilitas Sekolah','fasilitas-sekolah','fasilitas.png',1),
(6,'Extra Kurikuler','extra-kurikuler','extra.png',1),
(7,'Kegiatan','kegiatan','aktivitas.png',1),
(8,'Galeri Foto','galeri-foto','foto.png',1),
(9,'Galeri Video','galeri-video','video.png',1);

/*Table structure for table `kategori_konten` */

DROP TABLE IF EXISTS `kategori_konten`;

CREATE TABLE `kategori_konten` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_jenis` int(11) DEFAULT 1,
  `kategori_konten` varchar(50) DEFAULT NULL,
  `kategori_url` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `kategori_konten` */

insert  into `kategori_konten`(`idx`,`idx_jenis`,`kategori_konten`,`kategori_url`,`aktif`) values 
(1,1,'Berita','berita',1),
(2,1,'Sepak Bola','Sepak-Bola',1),
(3,1,'Kesehatan','Kesehatan',1),
(4,1,'Pendidikan','Pendidikan',1);

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `kelasid` int(11) NOT NULL AUTO_INCREMENT,
  `kelasta` varchar(11) DEFAULT NULL,
  `kelassemid` int(11) DEFAULT NULL,
  `kelasnama` varchar(15) DEFAULT NULL,
  `kelasstatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`kelasid`),
  KEY `kelassemid` (`kelassemid`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`kelassemid`) REFERENCES `semester` (`semid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `kelas` */

insert  into `kelas`(`kelasid`,`kelasta`,`kelassemid`,`kelasnama`,`kelasstatus`) values 
(3,'2021/2022',1,'VI - 1',1),
(4,'2021/2022',1,'VI - 2',1),
(5,'2021/2022',1,'VI - 3',1);

/*Table structure for table `kelasmapel` */

DROP TABLE IF EXISTS `kelasmapel`;

CREATE TABLE `kelasmapel` (
  `kmid` int(11) NOT NULL AUTO_INCREMENT,
  `kmkelasid` int(11) DEFAULT NULL,
  `kmmapelid` int(11) DEFAULT NULL,
  PRIMARY KEY (`kmid`),
  KEY `kmkelasid` (`kmkelasid`),
  KEY `kmmapelid` (`kmmapelid`),
  CONSTRAINT `kelasmapel_ibfk_1` FOREIGN KEY (`kmkelasid`) REFERENCES `kelas` (`kelasid`),
  CONSTRAINT `kelasmapel_ibfk_2` FOREIGN KEY (`kmmapelid`) REFERENCES `mapel` (`mapelid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `kelasmapel` */

insert  into `kelasmapel`(`kmid`,`kmkelasid`,`kmmapelid`) values 
(6,5,1),
(7,5,2),
(8,5,3),
(9,5,4),
(11,4,1),
(12,4,2),
(13,4,3),
(14,4,4),
(15,3,1),
(16,3,2),
(17,3,3),
(18,3,4),
(19,3,5),
(20,4,5);

/*Table structure for table `kelassiswa` */

DROP TABLE IF EXISTS `kelassiswa`;

CREATE TABLE `kelassiswa` (
  `ksid` int(11) NOT NULL AUTO_INCREMENT,
  `kskelasid` int(11) DEFAULT NULL,
  `ksnis` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ksid`),
  KEY `kskelasid` (`kskelasid`),
  KEY `ksnis` (`ksnis`),
  CONSTRAINT `kelassiswa_ibfk_1` FOREIGN KEY (`kskelasid`) REFERENCES `kelas` (`kelasid`),
  CONSTRAINT `kelassiswa_ibfk_2` FOREIGN KEY (`ksnis`) REFERENCES `siswa` (`nis`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `kelassiswa` */

insert  into `kelassiswa`(`ksid`,`kskelasid`,`ksnis`) values 
(5,3,'0989870'),
(6,3,'0989878'),
(7,3,'0989879');

/*Table structure for table `komentar` */

DROP TABLE IF EXISTS `komentar`;

CREATE TABLE `komentar` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_konten` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `isi_komentar` text DEFAULT NULL,
  `status_komentar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `komentar` */

insert  into `komentar`(`idx`,`idx_konten`,`tanggal`,`email`,`nama`,`isi_komentar`,`status_komentar`) values 
(1,71,'2021-09-24 21:43:30','bajoebel@gmail.com','Wanhar Azri','Terima Kasih Atas Ilmunya, kami merasa artikelini menambah wawasan',1),
(11,71,'2021-09-24 22:30:11','asd','asdsa','asdasd',1),
(12,71,'2021-09-24 22:31:19','fsdf','sdfsd','sdfdsf',1),
(13,71,'2021-09-24 22:31:55','sdfsd','sdfdsf','sdfsdf',1),
(14,71,'2021-09-24 22:32:35','asd','asd','asd',1),
(15,71,'2021-09-24 22:33:18','gsfgsfdg','dfgfeg','sdfgfsg',1),
(16,71,'2021-09-24 22:34:39','fghfgh','fhgfh','fhfghfg',1),
(17,71,'2021-09-24 22:35:11','saas','asd','asd',1),
(18,71,'2021-09-24 22:38:20','asd','asd','asd',1),
(19,71,'2021-09-24 22:39:20','sdf','sdfds','sdfdsf',1),
(20,72,'2021-09-24 22:46:33','bajoebel@gmail.com','Wanhar Azri','Ini adalh komentar',1),
(21,71,'2021-10-26 14:27:01','bajoebel@gmail.com','Wanhar Azri','Coba Komentar',1);

/*Table structure for table `konten` */

DROP TABLE IF EXISTS `konten`;

CREATE TABLE `konten` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_jenis` int(11) DEFAULT NULL,
  `idx_kategori` int(11) DEFAULT NULL,
  `judul_konten` varchar(100) DEFAULT NULL,
  `link_konten` varchar(100) DEFAULT NULL,
  `isi_konten` text DEFAULT NULL,
  `tgl_buat` datetime DEFAULT NULL,
  `tgl_publish` date DEFAULT NULL,
  `tgl_expire` date DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0 COMMENT 'Diisi ketika jenis konten fasilitas',
  `hits` int(11) DEFAULT 0,
  `komentar` tinyint(1) DEFAULT 0,
  `publish` tinyint(1) DEFAULT 1,
  `user_pembuat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

/*Data for the table `konten` */

insert  into `konten`(`idx`,`idx_jenis`,`idx_kategori`,`judul_konten`,`link_konten`,`isi_konten`,`tgl_buat`,`tgl_publish`,`tgl_expire`,`jumlah`,`hits`,`komentar`,`publish`,`user_pembuat`) values 
(60,4,0,'Ini contoh Agenda Kegiatan','Ini-contoh-Agenda-Kegiatan','<p>Ini contoh Agenda Kegiatan</p>\r\n','2021-09-12 21:15:25','2021-09-12','0000-00-00',0,2,1,1,'su'),
(61,1,1,'Efektifitas Pembelajaran Anak Usia Dini Di Masa Pandemi Covid 19','Efektifitas-Pembelajaran-Anak-Usia-Dini-Di-Masa-Pandemi-Covid-19','<p>Masuknya Virus Corona di Indonesia membawa dampak besar terhadap kehidupan masyarkat mulai dari Kehidupan Kesehatan, ekonomi Sosial, Keagamaan maupun duni a Pendidikan Dampak Virus Corona dalam dunia Pendidikan terlihat pada kebijakan Pemerintah Pusat hingga Pemerintah Daerah memberikan kebijakan untuk meliburkan seluruh lembaga Pendidikan dari tingkat Pendidikan Anak Usia Dini (PAUD) sampai Perguruan Tinggi. Hal ini dilakukan sebagai upaya mencegah meluasnya penularan Virus Corona. Diharapkan dengan seluruh lembaga Pendidikan tidak melakukan aktivitas tatap muka. Hal ini menuntut para Pendidik untuk lebih kreatif mengelola Pembelajaran secara Online. Sehingga proses Pembelajaran tetap berlangsung. Tidak terkecuali Pendidikan Anak Usia Dini (PAUD) Guru harus dituntut lebih kreatif, dalam mengelola Pembelajaran dimasa Pandemi Covid-19 ini.</p>\r\n\r\n<p>&nbsp;&nbsp;Melihat kondisi sistem Pembelajaran saat ini banyak ditemui dilapangan lembaga Pendidikan Anak Usia Dini (PAUD) yang belum memungkinkan untuk melakukan sistem belajar secara Online atau Jarak Jauh dikarnakan banyak kendala dan belum mampunya Anak-anak atau Orang Tua dalam mengoperasikan Gedget atau Media Teknologi dan masih banyak kendala lainnya.</p>\r\n\r\n<p>&nbsp;&nbsp;Sedangkan Perkembangan kemampuan belajar pada Anak Usia Dini masih dalam tahap untuk meniru. Anak belajar dari apa yang dilihat dan didengar. Dan prinsip belajar pada Pendidikan Anak Usia Dini (PAUD) yakni belajar sambil bermain, banyak juga orang tua mengatakan bahwa anak-anak lebih menykai dan lebih may melakukan kegiatan belajar bersama teman-temannya dan guru. Diakarenakan orang tua anak biasanya malah dibentak-bentak yang jga efeknya kurang bagus bagi anak.</p>\r\n\r\n<p>Bahkan anak cenderung merasakan kebosanan ketika belajar dengan orang tua, mungkin karena keadaan&nbsp;situasu dan kondisi anak jadi kurang semangat belajar dirumah sehingga jenuh tidak ada teman-teman dan tidak ada yang memotivasi karena biasanya disekolah guru menyamapaikan pembelajaran diselingi dengan seni ada tepuk angan, bernyanyi dan selingan berbagai kreativitas lainnya. Sedangkan dirumah orang tua lebih cenderung menuntut anak untuk mampu atau bisa menguasai bidang pembelajaran dan cenderung monoton.</p>\r\n\r\n<p>Tidak bisa dipugkiri salah satu sifat anak-anak adalah mereka sangat mudah untuk berubah pikiran dan berubah suasana hatinya. Hal tersebut dikarenakan anak usia dini belum bisa mengontrol diri dengan baik, kebanyakan dari mereka belum bisa berkumnikasi dengan lancar dan menyampaikan apa yang dirasakan. Hal ini masih ditambah faktor atmosfir belajar anak yang tiba-tiba berubah dari yang biasanya dilakukan bersama teman-temannya dengan penuh warna dan kreativitas. Sekarang harus dilakukan sendirian dan kurang menarik, suasana hati dan emosi anak yang sering kali berubah secara tiba-tiba membuat orang tua merasa bingung dan kewalahan, tidak semua orang tua paham bagaimana menghadapi anak yang berprilaku tidak sesuai harapan. Dalam situasi ini tidak jrang orang tua gagal membentuk komunikasi dengan anak. Alih-alih memahami prilaku anak, justru orang tua lebih sering marah dan membentak anak. Hal ini tentu akan kontrakatif dengan proses pembelajaran yang sering dilakukan. Para orang tua juga kewalahan dalam pelaksnaan pembelajaran dirumah untuk anak usia dini dikarenakan anak tidak mau belajar dan malah pergi bermain yang merasakan bahw sekolah libur untuk bermain serta menyepelekan tugas dari para guru dan terbatasnya waktu para orang tua dalam melakukan pendampingan belajar karena orang tua juga harus mencari nafkah, apalagi pada saat in usia dini memiliki rasa ingin tahu yang tinggi.</p>\r\n\r\n<p>Penggunaan media pembelajaran elektrinik ini juga terkadang malah membuat anak cendrung untuk bermain game yang katanya lebih mengasyikkan sehingga proses pembelajaran anak usia dini dimasa pandemi Covid 19 ini tidak akan berjalan sesuai yang diharapkan. Karena faktor kurang semangatnya anak dan kurannya kemampuan orang tua dalam mendampingi anak saat proses pembelajaran.</p>\r\n\r\n<p>Sumber ; https://ayoguruberbagi.kemdikbud.go.id/artikel/efektifitas-pembelajaran-anak-usia-dini-di-masa-pandemi/</p>\r\n\r\n<p>&nbsp;</p>\r\n','2021-09-21 22:09:19','2021-09-17','0000-00-00',0,0,1,1,'su'),
(62,2,0,'Halaman','Halaman','','2021-09-17 13:51:03','2021-09-17','0000-00-00',0,0,1,1,'su'),
(63,3,0,'Pengumuman','Pengumuman','<p>Pengumuman</p>\r\n','2021-09-17 13:52:02','2021-09-17','0000-00-00',0,1,1,1,'su'),
(64,5,0,'Kelas Teori','Kelas-Teori','<p>Ruang Belajar Siswa</p>\r\n','2021-09-21 22:40:55','2021-09-17','0000-00-00',24,1,1,1,'su'),
(65,6,0,'Footsal','Footsal','','2021-09-17 13:59:04','2021-09-17','0000-00-00',0,0,1,1,'su'),
(66,7,0,'Lomba Footsal','Lomba-Footsal','<p>Akan diadakan</p>\r\n','2021-09-17 14:01:20','2021-09-17','0000-00-00',0,0,1,1,'su'),
(67,8,0,'Galery Foto','Galery-Foto','','2021-09-17 14:03:55','2021-09-17','0000-00-00',0,0,1,1,'su'),
(68,9,0,'Galery Video','Galery-Video','','2021-09-28 00:31:06','2021-09-17','0000-00-00',0,0,1,1,'su'),
(69,1,4,'Apa Sih Pentingnya Pendidikan Anak Usia Dini?','Apa-Sih-Pentingnya-Pendidikan-Anak-Usia-Dini?','<p>Sebagai orangtua, sangat penting untuk mengetahui pentingnya pendidikan anak usia dini. Pasalnya, pendidikan usia dini menjadi pondasi bagi si Kecil dalam membangun kemampuan dasar yang diperlukan dalam pendidikannya di masa mendatang.</p>\r\n\r\n<p>Anak usia dini sendiri, menurut Perserikatan Bangsa-Bangsa (PBB), adalah anak yang berusia 0-8 tahun. Pada periode ini, perkembangan otak anak sangat pesat karena anak menyerap segala jenis informasi dari lingkungan dan orang-orang yang berada di sekitarnya.Di Indonesia, pendidikan anak usia dini sendiri diwujudkan dalam bentuk pendidikan prasekolah bernama PAUD untuk anak 0-6 tahun. Pengertian Paud adalah jenjang pendidikan yang ditempuh sebelum anak masuk ke sekolah dasar. Kementerian Pendidikan dan Kebudayaan menyatakan tujuan PAUD diadakan agar anak lebih siap sebelum memasuki pendidikan lebih lanjut.</p>\r\n\r\n<h2>Apa pentingnya pendidikan anak usia dini?</h2>\r\n\r\n<p>Pemerintah memandang pentingnya pendidikan usia dini sebagai titik sentral untuk membangun <a href=\"https://www.sehatq.com/artikel/mengoptimalkan-perkembangan-anak-usia-dini\" target=\"_blank\">pondasi dasar kepribadian anak</a>, demi menjadi manusia yang beradab di masa mendatang. Selain itu, pentingnya pendidikan usia dini yang lainnya meliputi:</p>\r\n\r\n<ul>\r\n	<li>Meningkatkan kesehatan dan kesejahteraan fisik maupun mental. Muaranya adalah peningkatan prestasi belajar, karakter yang pantang menyerah, lebih mandiri, dan anak mampu mengoptimalkan potensi yang dimilikinya.</li>\r\n	<li>Mengembangkan kapasitas dan efektivitas otak anak mengingat usia ini merupakan periode emas dengan perkembangan otak mencapai 80 persen.</li>\r\n	<li>Membentuk anak yang sukses di masa mendatang.</li>\r\n</ul>\r\n\r\n<p>Pentingnya pendidikan usia dini memang tidak dapat menghasilkan kesuksesan secara instan. Orangtua baru akan melihat hasilnya saat anak beranjak dewasa atau setidaknya mengenyam pendidikan di jenjang yang lebih tinggi.Anak yang mendapatkan pendidikan terbaik sejak usia 0-6 tahun memiliki harapan lebih besar untuk meraih keberhasilan di masa mendatang. Sebaliknya, anak yang tidak mendapatkan pendidikan yang memadai harus berjuang lebih berat untuk mengembangkan hidupnya.</p>\r\n\r\n<h2>Apa saja yang dipelajari dalam pendidikan anak usia dini?</h2>\r\n\r\n<p>Pendidikan anak usia dini adalah sistem pengajaran yang berfokus <a href=\"https://www.sehatq.com/artikel/tips-mendorong-perkembangan-anak-prasekolah\" target=\"_blank\">pada perkembangan</a> fisik, kognitif, emosional, dan sosial anak. Institusi PAUD juga harus menetapkan kurikulum yang dapat menggali potensi pada masing-masing anak.Selain itu, pelajaran PAUD harus diberikan dalam suasana yang menyenangkan untuk anak. Beberapa aktivitas yang dapat dilakukan oleh anak saat berada di institusi PAUD adalah:</p>\r\n\r\n<ul>\r\n	<li>Kegiatan artistik dan keterampilan, seperti menggambar, melukis, membuat model, kegiatan yang dekat dengan keseharian seperti membersihkan rumah.</li>\r\n	<li>Bermain dengan mainan, permainan simbolik, permainan sensorik, bermain dengan pasir dan air, game konstruksi, dan lain-lain.</li>\r\n	<li>Aktivitas musik dan gerakan, misalnya <a href=\"https://www.sehatq.com/artikel/manfaat-alat-musik-bagi-anak\" target=\"_blank\">memainkan alat musik</a>, bernyanyi, menghapalkan lagu, dan lain-lain.</li>\r\n	<li>Kegiatan komunikasi dan kreatif, misalnya bercerita, menghafal dongeng, membaca buku, membaca komik edukatif, dan lain-lain.</li>\r\n	<li>Kegiatan yang melatih kepekaan, seperti pengamatan, pembacaan dengan gambar, matematika, pembicaraan, dan bereksperimen.</li>\r\n	<li>Kegiatan di luar ruangan, seperti jalan-jalan, bermain pasir di pantai, olahraga, dan lain-lain.</li>\r\n</ul>\r\n\r\n<p>Meski ada anak yang menonjol dari sisi akademis di usia dini, institusi PAUD sebaiknya tidak menggeneralisir anak dari pencapaian akademisnya. Pasalnya, sifat alamiah anak di usia ini memang masih lebih suka bermain.Sebaliknya, pelajaran PAUD lebih menekankan pada kemajuan anak dalam aspek sosio-emosionalnya. Misalnya, guru PAUD mengajarkan anak untuk menghargai temannya yang berbeda agama, mau berbagi makanan pada temannya yang tidak membawa bekal, atau membantu temannya yang sedang dalam kesusahan apa pun.Guru juga dapat melatih disiplin anak lewat hal-hal yang kecil, misalnya merapikan sepatu sebelum masuk kelas, membereskan kursi setelah selesai belajar, dan lain-lain. Sesekali, dalam pelajaran PAUD, guru juga bisa memberi proyek sesuai potensi anak untuk melatih kemampuan <em>problem solving</em> mereka.</p>\r\n\r\n<h2>Perbedaan PAUD Formal dan Nonformal</h2>\r\n\r\n<p>Perlu Anda ketahui bahwa terdapat PAUD formal dan nonformal. PAUD formal adalah pendidikan anak usia dini yang dilaksakan oleh sebuah lembaga pendidikan formal. Bentuknya dapat berupa Taman Kanak-Kanak (TK) atau Raudhotul Anfal (RA). Pembelajarannya pun dibuat dan disampaikan oleh guru lulusan PAUD atau sejenisnya.Sementara itu, PAUD nonformal merupakan pendidikan anak usia dini yang dilaksanakan oleh lembaga bersifat nonformal, seperti <em>playgroup</em>, tempat penitipan anak, dan lainnya. Umumnya, pendidikan ini ditempuh sebelum anak menjalani pendidikan formal. Misalnya, setelah anak belajar di <em>playgroup</em>, selanjutnya ia masuk TK.</p>\r\n\r\n<h2>Siapa saja yang harus terlibat dalam pendidikan anak usia dini?</h2>\r\n\r\n<p>Salah satu hal yang paling sering dilewatkan oleh orangtua dalam memahami pentingnya pendidikan usia dini adalah pelibatan pihak mana saja dalam pembentukan pondasi dasar karakter anak. Memilih institusi PAUD dengan kurikulum yang bagus saja tidak cukup karena peran orangtua dan guru juga sama pentingnya.Institusi PAUD dituntut menerapkan sistem belajar yang mengombinasikan ilmu pengetahuan, teknologi, praktik, hingga matematika. Sedangkan guru harus mampu mengambil hati anak agar ia dapat menyerap ilmu yang diberikan oleh tenaga pengajar tersebut.Di sisi lain, orangtua juga harus menaruh perhatian pada hal-hal yang sedang dipelajari anak dan memantau perkembangannya. Ketika ketiga hal ini sudah berjalan dengan baik, maka semakin besar kemungkinan anak akan menjadi orang yang berhasil di masa mendatang.</p>\r\n','2021-09-21 22:11:34','2021-09-21','0000-00-00',0,0,1,1,'su'),
(70,1,4,'Pendidikan Sekolah Dasar dan Metode Pembelajarannya','Pendidikan-Sekolah-Dasar-dan-Metode-Pembelajarannya','<p>Tingkat satuan pendidikan yang dianggap sebagai dasar pendidikan adalah&nbsp;<a href=\"http://www.artikelbagus.com/2012/03/artikel-pendidikan-sekolah-dasar.html\">sekolah dasar</a>. Di sekolah inilah anak didik mengalami proses pendidikan dan pembelajaran.</p>\r\n\r\n<p>Dan,secara umum pengertian sekolah dasar dapat kita katakan sebagai institusi pendidikan yang menyelenggarakan proses pendidikan dasar dan mendasari proses pendidikan selanjutnya.</p>\r\n\r\n<p>Pendidikan ini diselenggarakan untuk anak-anak yang telah berusia tujuh tahun dengan asumsi bahwa anak seusia tersebut mempunyai tingkat pemahaman dan kebutuhan pendidikan yang sesuai dengan dirinya. Pendidikan dasar memang diselenggarakan untuk memberikan dasar pengetahuan, sikap dan keterampilan bagi anak didik.&nbsp;</p>\r\n\r\n<p>Pendidikan dasar inilah yang selanjutnya dikembangkan untuk meningkatkan kualitas diri anak didik.</p>\r\n\r\n<p>Kita seharusnya memahami pengertian sekolah dasar sehingga dapat mengikuti setiap kegiatan yang diselenggarakan di tingkat ini.</p>\r\n\r\n<p>Walaupun, kita mengenal pendidikan anak usia dini (PAUD), tetapi setidaknya mereka lebih mengedepankan untuk melatih anak bersosialisasi dengan teman dan masyarakat,bukan untuk mengikuti pendidikan dan pembelajaran yang mengarah pada pemahaman pengetahuan.&nbsp;</p>\r\n\r\n<p>&nbsp; Tujuan operasional pendidikan SD, dinyatakan di dalam Kurikulum Pendidikan Dasar yaitu memberi bekal kemampuan dasar membaca, menulis dan berhitung, pengetahuan dan ketrampilan dasar yang bermanfaat bagi siswa sesuai dengan tingkat perkembangannya, serta mempersiapkan mereka untuk mengikuti pendidikan di SLTP.</p>\r\n\r\n<p>Di sekolah dasar, kegiatan pembekalan diberikan selama enam tahun berturut-turut. Pada saat inilah anak didik dikondisikan untuk dapat bersikap sebaik-baiknya.</p>\r\n\r\n<p>Pengertian sekolah dasar sebagai basis pendidikan harus benar-benar dapat dipahami oleh semua orang sehingga mereka dapat mengikuti pola pendidikannya.</p>\r\n\r\n<p>Tentunya, dalam hal ini, kegiatan pendidikan dan pembelajarannya mengedepankan landasan bagi kegiatan selanjutnya. Tanpa pendidikan dasar, tentunya sulit bagi kita untuk memahami konsep-konsep baru pada tingkatan lebih tinggi.</p>\r\n\r\n<p>Pembelajaran adalah usaha guru untuk menciptakan suasana yang menyenangkan untuk belajar (enjoy learning), yang membuat siswa dipanggil untuk belajar.</p>\r\n\r\n<p>Agar pembelajaran menyenangkan maka guru harus memilih metode yang tepat.Agar tujuan pengajaran tercapai sesuai dengan yang telah dirumuskan oleh pendidik,maka perlu mengetahui,mempelajari beberapa metode mengajar, serta dipraktekkan pada saat mengajar.</p>\r\n\r\n<p>Pemilihan metode mengajar harus mempertimbangkan pengembangan kemampuan siswa yang lebih kreatif inovatif dan dikondisikan pada pembelajaran yang bersifat problematis.</p>\r\n\r\n<p>Pembelajaran yang memungkinkan siswa belajar secara mandiri dan belajar secara kelompok.</p>\r\n\r\n<p>Metode mengajar memiliki fungsi sentral dalam pembelajaran diantaranya yaitu sebagai alat atau cara untuk mencapai tujuan pembelajaran.</p>\r\n\r\n<p>Tujuan pembelajaran yang harus dikembangkan berdasarkan ranah tujuan kognitif, afektif dan psikomotor. Ranah tujuan tersebut akan memungkinkan dicapai pada tujuan yang bersifat umum.</p>\r\n\r\n<p>Metode pembelajaran yang tepat bagi siswa sekolah dasar yaitu :<br />\r\n<br />\r\n1. METODE TANYA-JAWAB<br />\r\nMetode tanya-jawab digunakan dengan maksud :<br />\r\n&bull; Melanjutkan (meninjau) pelajaran yang lalu<br />\r\n&bull; Menyelingi pembicaraan untuk mendapatkan kerjasama siswa<br />\r\n&bull; Memimpin pengamatan dan pemikiran siswa.<br />\r\n<br />\r\n2. METODE DISKUSI<br />\r\nMetode diskusi adalah cara penyampaian bahan pelajaran dimana guru memberi kesempatan kepada siswa untuk mengumpulkan pendapat, membuat kesimpulan atau menyusun berbagai alternatif pemecahan masalah.<br />\r\n<br />\r\n3. METODE KERJA KELOMPOK<br />\r\nKerja kelompok dapat diartikan sebagai suatu kegiatan belajar-mengajar dimana siswa dalam suatu kelas dipandang sebagai suatu kelompok atau dibagi atas kelompok-kelompok kecil untuk mencapai suatu tujuan pengajaran tertentu.<br />\r\n<br />\r\n4. METODE DEMONSTRASI DAN EKSPERIMEN<br />\r\nAntara metode demonstrasi dan eksperimen sebenarnya berbeda, akan tetapi dalam praktek sering dipergunakan silih berganti atau saling melengkapi.<br />\r\n<br />\r\n5. METODE SOSIODRAMA DAN BERMAIN PERANAN<br />\r\nMetode sosiodrama dan bermain peranan merupakan dua buah metode mengajar yang mengandung pengertian yang dapat dikatakan bersama dan karenanya dalam pelaksanaan sering disilih gantikan.</p>\r\n','2021-09-21 22:26:40','2021-09-21','0000-00-00',0,1,1,1,'su'),
(71,1,4,' Metode pembelajaran pada anak SD ','-Metode-pembelajaran-pada-anak-SD-','<p>ecara umum pengertian sekolah dasar dapat kita katakan sebagai institusi pendidikan yang menyelenggarakan proses pendidikan dasar dan mendasari proses pendidikan selanjutnya.</p>\r\n\r\n<p>Pendidikan ini diselenggarakan untuk anak-anak yang telah berusia tujuh tahun dengan asumsi bahwa anak seusia tersebut mempunyai tingkat pemahaman dan kebutuhan pendidikan yang sesuai dengan dirinya. Pendidikan dasar memang diselenggarakan untuk memberikan dasar pengetahuan, sikap dan keterampilan bagi anak didik.</p>\r\n\r\n<p>Pendidikan dasar inilah yang selanjutnya dikembangkan untuk meningkatkan kualitas diri anak didik.</p>\r\n\r\n<p>Kita seharusnya memahami pengertian sekolah dasar sehingga dapat mengikuti setiap kegiatan yang diselenggarakan di tingkat ini.</p>\r\n\r\n<p>Walaupun, kita mengenal pendidikan anak usia dini (PAUD), tetapi setidaknya mereka lebih mengedepankan untuk melatih anak bersosialisasi dengan teman dan masyarakat,bukan untuk mengikuti pendidikan dan pembelajaran yang mengarah pada pemahaman pengetahuan.</p>\r\n\r\n<p>Tujuan operasional pendidikan SD, dinyatakan di dalam Kurikulum Pendidikan Dasar yaitu memberi bekal kemampuan dasar membaca, menulis dan berhitung, pengetahuan dan ketrampilan dasar yang bermanfaat bagi siswa sesuai dengan tingkat perkembangannya, serta mempersiapkan mereka untuk mengikuti pendidikan di SLTP.</p>\r\n\r\n<p>Di sekolah dasar, kegiatan pembekalan diberikan selama enam tahun berturut-turut. Pada saat inilah anak didik dikondisikan untuk dapat bersikap sebaik-baiknya.</p>\r\n\r\n<p>Pengertian sekolah dasar sebagai basis pendidikan harus benar-benar dapat dipahami oleh semua orang sehingga mereka dapat mengikuti pola pendidikannya.</p>\r\n\r\n<p>Tentunya, dalam hal ini, kegiatan pendidikan dan pembelajarannya mengedepankan landasan bagi kegiatan selanjutnya. Tanpa pendidikan dasar, tentunya sulit bagi kita untuk memahami konsep-konsep baru pada tingkatan lebih tinggi.</p>\r\n\r\n<p>Pembelajaran adalah usaha guru untuk menciptakan suasana yang menyenangkan untuk belajar (enjoy learning), yang membuat siswa dipanggil untuk belajar.</p>\r\n\r\n<p>Agar pembelajaran menyenangkan maka guru harus memilih metode yang tepat.Agar tujuan pengajaran tercapai sesuai dengan yang telah dirumuskan oleh pendidik,maka perlu mengetahui,mempelajari beberapa metode mengajar, serta dipraktekkan pada saat mengajar.</p>\r\n\r\n<p>Pemilihan metode mengajar harus mempertimbangkan pengembangan kemampuan siswa yang lebih kreatif inovatif dan dikondisikan pada pembelajaran yang bersifat problematis.</p>\r\n\r\n<p>Pembelajaran yang memungkinkan siswa belajar secara mandiri dan belajar secara kelompok.</p>\r\n\r\n<p>Metode mengajar memiliki fungsi sentral dalam pembelajaran diantaranya yaitu sebagai alat atau cara untuk mencapai tujuan pembelajaran.</p>\r\n\r\n<p>Tujuan pembelajaran yang harus dikembangkan berdasarkan ranah tujuan kognitif, afektif dan psikomotor. Ranah tujuan tersebut akan memungkinkan dicapai pada tujuan yang bersifat umum.</p>\r\n\r\n<p>Metode pembelajaran yang tepat bagi siswa sekolah dasar yaitu :</p>\r\n\r\n<p>1. METODE TANYA-JAWABMetode tanya-jawab digunakan dengan maksud : Melanjutkan (meninjau) pelajaran yang lalu Menyelingi pembicaraan untuk mendapatkan kerjasama siswa Memimpin pengamatan dan pemikiran siswa.</p>\r\n\r\n<p>2. METODE DISKUSIMetode diskusi adalah cara penyampaian bahan pelajaran dimana guru memberi kesempatan kepada siswa untuk mengumpulkan pendapat, membuat kesimpulan atau menyusun berbagai alternatif pemecahan masalah.</p>\r\n\r\n<p>3. METODE KERJA KELOMPOKKerja kelompok dapat diartikan sebagai suatu kegiatan belajar-mengajar dimana siswa dalam suatu kelas dipandang sebagai suatu kelompok atau dibagi atas kelompok-kelompok kecil untuk mencapai suatu tujuan pengajaran tertentu.</p>\r\n\r\n<p>4. METODE DEMONSTRASI DAN EKSPERIMENAntara metode demonstrasi dan eksperimen sebenarnya berbeda, akan tetapi dalam praktek sering dipergunakan silih berganti atau saling melengkapi.</p>\r\n\r\n<p>5. METODE SOSIODRAMA DAN BERMAIN PERANANMetode sosiodrama dan bermain peranan merupakan dua buah metode mengajar yang mengandung pengertian yang dapat dikatakan bersama dan karenanya dalam pelaksanaan sering disilih gantikan</p>\r\n','2021-09-21 22:28:03','2021-09-21','0000-00-00',0,10,1,1,'su'),
(72,1,4,'Pentingnya Peran Orang tua Dalam Pendidikan Anak di Zaman Modern','Pentingnya-Peran-Orang-tua-Dalam-Pendidikan-Anak-di-Zaman-Modern','<p>Pendidikan merupakan suatu aktivitas untuk mengembangkan seluruh aspek kepribadian manusia yang berjalan seumur hidup. Pendidikan tidak hanya berlangsung dikelas, tetapi berlangsung pula diluar kelas.</p>\r\n\r\n<p>Namun pendidikan anak dijaman sekarang ini mulai rentan karena kurangnya perhatian orang tua terhadap pendidikan anak itu sendiri.</p>\r\n\r\n<p>Contoh kurangnya perhatian orang tua terhadap pendidikan seperti, seorang anak tidak naik kelas dan malas sekolah serta mulai mengenal pergaulan bebas. Itu di sebabkan karena kurang nya peran orang tua terhadap anak. Saat ini orang tua sibuk dengan gadget dan bekerja sehingga hal ini dapat mempengaruhi pendidikan anak nya.</p>\r\n\r\n<p>Peranan orang tua dalam pendidikan sangat penting, serta tanggung jawab mendidik seorang anak tidak hanya pada guru disekolah namun juga orang tua nya, karna orang tua adalah guru pertama seorang anak untuk mendapatkan pelajaran yang baik. Contoh nya orang tua mengajar kan sikap yang baik kepada anak-anak nya, hormat kepada orang yang lebih tua dan sopan santun .</p>\r\n\r\n<p>Orang tua merupakan lingkungan pertama anak, karena kehidupan seorang anak tidak lepas dari orang tua. Seorang anak biasanya meniru sikap orang yang ada di sekitarnya. Oleh karena itu, dalam perkembangan kepribadian anak, faktor orang tua untuk memberikan pelajaran terutama dalam akhlaq atau perilaku yang baik dan mengenalkan pelajaran di bidang keagamaan sangatlah penting.</p>\r\n\r\n<p>Secara umum Pengertian Pendidikan adalah sebagai usaha sadar dan terencana untuk mewujudkan suasana belajar dan proses pembelajaran untuk peserta didik secara aktif mengembangkan potensi dirinya untuk memiliki kekuatan spiritual keagamaan, pengendalian diri, kepribadian, kecerdasan, akhlak mulia, serta keterampilan yang diperlukan dirinya dan masyarakat.</p>\r\n\r\n<p>Pendidikan dapat diartikan sebagai usaha sadar dan sistematis untuk mencapai taraf hidup atau&nbsp; untuk kemajuan lebih baik. Secara sederhana, Pengertian pendidikan adalah proses pembelajaran bagi peserta didik untuk dapat mengerti, paham, dan membuat manusia lebih kritis dalam berpikir.</p>\r\n\r\n<p>Suasana pendidikan yang di peroleh dari orang tua perlu diperhatikan karena dari situlah perkembangan jiwa individu selanjutnya di tentukan.</p>\r\n\r\n<p>Namun, dikalangan kita sudah banyak kalangan orang tua yang sudah tidak memperhatikan pendidikan anak nya Karena kesibukannya dalam bekerja atau hal lainnya.untuk membuktikan hal ini perlu teori tentang perhatian orang tua</p>\r\n\r\n<p>Menurut Purwandari (2006) dalam modul pembelajaran psikologi Umum, dijelaskan bahwa perhatian merupakan peningkatan kesadaran dari seluruh fungsi jiwa untuk dipusatkan pada sesuatu hal baik yang ada diluar maupun ada didalam diri seseorang.</p>\r\n\r\n<p>Orang tua adalah komponen keluarga yang terdiri dari ayah dan ibu, dan merupakan hasil dari sebuah ikatan perkawinan yang sah yang dapat membentuk suatu keluarga. Orang tua memiliki tanggung jawab untuk mendidik, mengasuh, membimbing anak-anaknya untuk mencapai tahapan tertentu yang menghantarkan anak untuk siap dalam kehidupan bermasyarakat.</p>\r\n\r\n<p>Berdasarkan uraian di atas dapat diketahui bahwa perhatian merupakan pemusatan atau konsentrasi yang menyebabkan bertambahnya aktivitas individu terhadap suatu obyek yang memberikan rangsangan kepada individu tersebut, sehingga ia memperdulikan obyek yang memberikan rangsangan tersebut.</p>\r\n\r\n<p>Dengan demikian perhatian orang tua merupakan pemusatan atau konsentrasi orang tua terhadap anaknya yang menyebabkan bertambahnya aktivitas orang tua yang ditujukan kepada anak-anaknya terutama dalam pemenuhan kebutuhan baik secara fisik maupun non fisik.</p>\r\n\r\n<p>Oleh karena itu sangat penting peran orang tua dalam memberikan perhatian kepada anak nya agar anak nya dapat belajar dengan giat di sekolahnya dan menghasilkan prestasi belajar disekolah dengan memberikan waktu luang kepada anak nya untuk kegiatan belajar mengajar dan selalu memberikan motivasi terhadap anak nya agar rajin belajar dan merasa senang .</p>\r\n','2021-09-21 22:31:51','2021-09-21','0000-00-00',0,9,1,1,'su'),
(73,5,0,'Labor Komputer','Labor-Komputer','','2021-09-21 22:44:57','2021-09-21','0000-00-00',1,5,1,1,'su'),
(74,5,0,'Perpustakaan','Perpustakaan','','2021-09-21 22:46:31','2021-09-21','0000-00-00',1,3,1,1,'su'),
(75,5,0,'UKS','UKS','','2021-09-21 22:51:07','2021-09-21','0000-00-00',1,1,1,1,'su'),
(76,3,0,'asa 2010/2021','asa-2010-2021','<p>asas</p>\r\n','2022-02-07 21:08:31','2022-02-07','0000-00-00',0,2,1,1,'su');

/*Table structure for table `lampiran_konten` */

DROP TABLE IF EXISTS `lampiran_konten`;

CREATE TABLE `lampiran_konten` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_konten` int(11) DEFAULT NULL,
  `nama_file` text DEFAULT NULL,
  `ext_file` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

/*Data for the table `lampiran_konten` */

insert  into `lampiran_konten`(`idx`,`idx_konten`,`nama_file`,`ext_file`) values 
(48,57,'files/berita/2021/berita__1_bruno-fernandes_169.jpeg','jpeg'),
(49,58,'files/halaman/2021/halaman__1_bruno-fernandes_169.jpeg','jpeg'),
(50,59,'files/pengumuman/2021/pengumuman__1_bruno-fernandes_169.jpeg','jpeg'),
(51,60,'files/agenda-kegiatan/2021/agenda-kegiatan__1_bruno-fernandes_169.jpeg','jpeg'),
(53,63,'files/kegiatan/2021/kegiatan__1_bruno-fernandes_169.jpeg','jpeg'),
(57,66,'files/galeri-foto/2021/galeri-foto__1_bruno-fernandes_1692.jpeg','jpeg'),
(58,67,'files/galeri-foto/2021/galeri-foto__1_bruno-fernandes_1693.jpeg','jpeg'),
(63,65,'files/galeri-foto/2021/galeri-foto__1_bruno-fernandes_1695.jpeg','jpeg'),
(64,65,'files/galeri-foto/2021/galeri-foto__2_omega-1_1691.jpeg','jpeg'),
(66,62,'files/halaman/2021/halaman__1_bruno-fernandes_1691.jpeg','jpeg'),
(69,65,'files/extra-kurikuler/2021/extra-kurikuler__1_bruno-fernandes_169.jpeg','jpeg'),
(70,66,'files/kegiatan/2021/kegiatan__1_bruno-fernandes_1691.jpeg','jpeg'),
(71,67,'files/galeri-foto/2021/galeri-foto__1_bruno-fernandes_1696.jpeg','jpeg'),
(72,67,'files/galeri-foto/2021/galeri-foto__2_bruno-fernandes_1691.jpeg','jpeg'),
(73,67,'files/galeri-foto/2021/galeri-foto__3_bruno-fernandes_1691.jpeg','jpeg'),
(75,61,'files/berita/2021/berita__1_pendidikandini.jpeg','jpeg'),
(76,69,'files/berita/2021/berita__1_pendidikandini_jga.jpg','jpg'),
(77,70,'files/berita/2021/berita__1_S662hcreenshot_1153.jpg','jpg'),
(78,71,'files/berita/2021/berita__1_ev7bxftkfb.jpg','jpg'),
(79,72,'files/berita/2021/berita__1_ilustrasi-siluet-keluarga.jpg','jpg'),
(80,64,'files/fasilitas-sekolah/2021/fasilitas-sekolah__1_ruang_kelas.jpg','jpg'),
(81,73,'files/fasilitas-sekolah/2021/fasilitas-sekolah__1_Tata-Tertib-Laboratorium-Komputer-FTTI-UNJANI-Yogyakarta.jpg','jpg'),
(82,74,'files/fasilitas-sekolah/2021/fasilitas-sekolah__1_64IMG-20210401-WA0227-1.jpg','jpg'),
(83,75,'files/fasilitas-sekolah/2021/fasilitas-sekolah__1_sdn-3-banjar-jawa-singaraja-juara-i-sekolah-sehat-2019-11-21-074935_0.jpg','jpg'),
(84,68,'files/galeri-video/2021/galeri-video__1_JUNDULLAH_NASHEED_LAGU_JIHAD_FISABILILLAH_PEJUANG_ALLAH_MUJAHID_AKHIR_ZAMAN.mp4','mp4'),
(85,68,'files/galeri-video/2021/galeri-video__1_Menggetarkan_jiwa_-_Diriku_membutuhkan_PertolonganMu_Ustadz_Armen_Halim_Naro,_Lc__Rahimahullah.mp4','mp4'),
(86,68,'files/galeri-video/2021/galeri-video__1_Masyaallah_Merinding_Dengar_Nasyid_Terbaik_Ini_-_Ghuroba_-_Rikhie_Asbo_(Official_Video).mp4','mp4');

/*Table structure for table `level_user` */

DROP TABLE IF EXISTS `level_user`;

CREATE TABLE `level_user` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `level_user` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `level_user` */

insert  into `level_user`(`idx`,`level_user`,`aktif`) values 
(1,'Super Admin',1),
(4,NULL,0),
(5,NULL,0),
(6,NULL,0),
(7,NULL,0);

/*Table structure for table `link_terkait` */

DROP TABLE IF EXISTS `link_terkait`;

CREATE TABLE `link_terkait` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `judul_link` varchar(50) DEFAULT NULL,
  `url_link` varchar(50) DEFAULT NULL,
  `gambar_link` text DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `link_terkait` */

insert  into `link_terkait`(`idx`,`judul_link`,`url_link`,`gambar_link`,`aktif`) values 
(2,'Kemendikbud Sumatera Barat','https://www.kemdikbud.go.id/main/','files/link_terkait/2021/link_terkait__1_20160628Kemdikbud-logo-002.jpg',1);

/*Table structure for table `mapel` */

DROP TABLE IF EXISTS `mapel`;

CREATE TABLE `mapel` (
  `mapelid` int(11) NOT NULL AUTO_INCREMENT,
  `mapelnama` varchar(50) DEFAULT NULL,
  `mapelkkm` double DEFAULT NULL,
  `mapelstatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`mapelid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `mapel` */

insert  into `mapel`(`mapelid`,`mapelnama`,`mapelkkm`,`mapelstatus`) values 
(1,'Bahasa Indonesia',80,1),
(2,'Bahas Inggris',80,1),
(3,'Fisika',80,1),
(4,'Kimia',80,1),
(5,'Akutansi',80,1);

/*Table structure for table `menu_admin` */

DROP TABLE IF EXISTS `menu_admin`;

CREATE TABLE `menu_admin` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `main_idx` int(11) DEFAULT 0,
  `judul_menu` varchar(30) DEFAULT NULL,
  `link_menu` varchar(35) DEFAULT NULL,
  `icon` varchar(30) DEFAULT 'fa-bars',
  `urut` int(11) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `menu_admin` */

insert  into `menu_admin`(`idx`,`main_idx`,`judul_menu`,`link_menu`,`icon`,`urut`,`aktif`) values 
(1,0,'Home','home','fa-home',1,1),
(2,0,'Semester','semester','fa-list-ul',2,1),
(3,0,'kotent','#','fa-desktop',3,1),
(4,3,'Berita','konten/berita','fa-bars',NULL,1),
(5,3,'Halaman','konten/halaman','fa-bars',NULL,1),
(6,3,'Pengumuman','konten/pengumuman','fa-bars',NULL,1),
(7,3,'Agenda','konten/agenda-kegiatan','fa-bars',NULL,1),
(8,3,'Fasilitas','konten/fasilitas-sekolah','fa-bars',NULL,1),
(9,3,'Extraskurikuler','konten/extra-kurikuler','fa-bars',NULL,1),
(10,3,'Kegiatan','konten/kegiatan','fa-bars',NULL,1),
(11,0,'Galery','#','fa-file-picture-o',4,1),
(12,11,'Foto','konten/galeri-foto','fa-bars',NULL,1),
(13,11,'Video','konten/galeri-video','fa-bars',NULL,1),
(14,0,'Pengaturan','#','fa-gears',9,1),
(15,14,'Profile','profile','fa-bars',NULL,1),
(16,14,'Level','level','fa-bars',NULL,1),
(17,14,'User','users','fa-bars',NULL,1),
(18,14,'Ubah Password','ubah_password','fa-bars',NULL,1),
(19,0,'Pengajar','pengajar','fa-users',4,1),
(20,0,'Menu Depan','menu','fa-bars',6,1),
(21,14,'Instansi','instansi','fa-bars',NULL,1),
(22,0,'Slider','slider','fa-sliders',7,1),
(23,0,'Link Terkait','link_terkait','fa-link',8,1);

/*Table structure for table `menu_depan` */

DROP TABLE IF EXISTS `menu_depan`;

CREATE TABLE `menu_depan` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `main_idx` int(11) DEFAULT NULL,
  `sub_idx` int(11) DEFAULT NULL,
  `sub_sub_idx` decimal(10,0) DEFAULT NULL,
  `judul_menu` varchar(50) DEFAULT NULL,
  `link_menu` varchar(55) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `menu_depan` */

insert  into `menu_depan`(`idx`,`main_idx`,`sub_idx`,`sub_sub_idx`,`judul_menu`,`link_menu`,`aktif`) values 
(1,1,0,0,'Home','',1),
(2,99,0,0,'Tentang Kami','#',1),
(3,99,1,0,'Visi Misi','visi-misi',1),
(4,99,2,0,'Tujuan','tujuan',1),
(5,99,3,0,'Sejarah','sejarah',1);

/*Table structure for table `nilai` */

DROP TABLE IF EXISTS `nilai`;

CREATE TABLE `nilai` (
  `nilaiid` int(11) NOT NULL AUTO_INCREMENT,
  `nilaikelasid` int(11) DEFAULT NULL,
  `nilainis` varchar(30) DEFAULT NULL,
  `nilaimapelid` int(11) DEFAULT NULL,
  `nilaiangka` double DEFAULT NULL,
  `nilaihuruf` char(2) DEFAULT NULL,
  PRIMARY KEY (`nilaiid`),
  KEY `nilainis` (`nilainis`),
  KEY `nilaikelasid` (`nilaikelasid`),
  CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nilainis`) REFERENCES `siswa` (`nis`),
  CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`nilaikelasid`) REFERENCES `kelas` (`kelasid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `nilai` */

insert  into `nilai`(`nilaiid`,`nilaikelasid`,`nilainis`,`nilaimapelid`,`nilaiangka`,`nilaihuruf`) values 
(1,3,'0989870',1,90,'A'),
(2,3,'0989878',1,80,'B'),
(3,3,'0989879',1,56,'D'),
(4,3,'0989870',2,45,'E'),
(5,3,'0989878',2,75,'C'),
(6,3,'0989879',2,87,'A');

/*Table structure for table `pengajar` */

DROP TABLE IF EXISTS `pengajar`;

CREATE TABLE `pengajar` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `nip_pengajar` varchar(50) DEFAULT NULL,
  `nama_pengajar` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `pendidikan_terakhir` varchar(50) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  `userinput` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `pengajar` */

insert  into `pengajar`(`idx`,`nip_pengajar`,`nama_pengajar`,`jenis_kelamin`,`tempat_lahir`,`tanggal_lahir`,`jabatan`,`agama`,`pendidikan_terakhir`,`foto`,`aktif`,`userinput`) values 
(2,'12345','Joko','Pria','Padang','2052-08-20','Guru Kelas','Islam','S1 PGSD','files/pengajar/2021/pengajar__1_blank-profile-male.png',1,NULL),
(3,'123','Meri','Wanita','Meri Nur Janah','2011-11-20','Guru Kelas','Islam','S1','files/pengajar/2021/pengajar__1_male-profile-picture.png',1,NULL);

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `idx` int(11) NOT NULL,
  `nama_sekolah` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `notelp` varchar(12) DEFAULT NULL,
  `fax` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `youtube` varchar(100) DEFAULT NULL,
  `nama_kepsek` varchar(50) DEFAULT NULL,
  `nip_kepsek` varchar(50) DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `tujuan` text DEFAULT NULL,
  `moto` varchar(255) DEFAULT NULL,
  `sejarah_sekolah` text DEFAULT NULL,
  `foto_kepsek` text DEFAULT NULL,
  `logo_sekolah` text DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `profile` */

insert  into `profile`(`idx`,`nama_sekolah`,`alamat`,`notelp`,`fax`,`email`,`facebook`,`twitter`,`instagram`,`youtube`,`nama_kepsek`,`nip_kepsek`,`visi`,`misi`,`tujuan`,`moto`,`sejarah_sekolah`,`foto_kepsek`,`logo_sekolah`) values 
(1,'SD Kartika 1-10 Padang ','Jl. Sisingamangaraja No.34, Simpang Haru, Kec. Pad','-','-','-','-','-','-','-','MUHAMMAD YUNUS, S.Pd','-','<p>Membentuk warga sekolah beriman, bertaqwa, berdisiplin, cerdas, komprehensif dan kompetitif yang berwawasan lingkungan</p>\r\n','<ol>\r\n	<li>Memantapkan pengalaman ajaran agama dalam kehidupan sehari-hari yang <strong>bernuansa lingkungan.</strong></li>\r\n	<li>Menciptakan suasana sekolah yang kondusif dan <strong>cinta lingkungan</strong>.</li>\r\n	<li>Meningkatkan kemampuan warga sekolah dalam bidang ilmu pengetahuan dengan mengaplikasikan Teknologi Informasi Komputer</li>\r\n	<li>Meningkatkan kemampuan warga sekolah mengakses informasi terbaru dari berbagai sumber</li>\r\n	<li>Memberi sanksi atas pelanggaran peraturan tata tertib sekolah</li>\r\n	<li>Melaksanakan senam pagi untuk kesehatan jasmani</li>\r\n	<li>Memelihara ketertiban, kebersihan, keindahan, keamanan, dan kekeluargaan serta <strong>menanamkan rasa peduli terhadap lingkungan</strong></li>\r\n</ol>\r\n','<p>Tujuan Pendidikan Dasar SD Kartika I-10 Padang mengacu pada tujuan umum pendidikan. Adapun tujuan umum pendidikan dasar adalah meletakkan dasar kecerdasan, pengetahuan, kepribadian, akhlak mulia serta keterampilan untuk hidup mandiri dan mengikuti pendidikan lebih lanjut. Mengacu pada tujuan umum pendidikan maka dapat dijabarkan tujuan Pendidikan Dasar adalah :</p>\r\n\r\n<ol>\r\n	<li>Meningkatkan keimanan dan <strong>taqwa kepada Tuhan yang Maha Esa</strong><strong> dan </strong><strong>peduli terhadap lingkungan </strong></li>\r\n	<li>Meningkatkan mutu pendidikan yang berlandasakan ajaran agama dan ilmu pengetahuan</li>\r\n	<li>Meraih prestasi yang lebih baik di tingkat Kota, Provinsi, dan Nasional</li>\r\n	<li>Melanjutkan sekolah ke SLTP favorit</li>\r\n</ol>\r\n','<p>-</p>\r\n','','files/profile/kepsek__1_kepsek8.jpg','files/profile/logo__1_logo2.png');

/*Table structure for table `semester` */

DROP TABLE IF EXISTS `semester`;

CREATE TABLE `semester` (
  `semid` int(11) NOT NULL AUTO_INCREMENT,
  `semnama` varchar(50) DEFAULT NULL,
  `semstatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`semid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `semester` */

insert  into `semester`(`semid`,`semnama`,`semstatus`) values 
(1,'Semester I',1),
(2,'Semester II',1),
(3,'Semester III',1),
(4,'Semester IV',1),
(5,'Semester V',1),
(6,'Semester VI',1),
(7,'Semester VII',1),
(8,'Semester VIII',1),
(9,'Semester IX',1),
(10,'Semester X',1),
(11,'Semester XI',1),
(12,'Semester XII',1);

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `nis` varchar(30) NOT NULL,
  `siswanama` varchar(50) DEFAULT NULL,
  `siswajekel` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `siswatmplahir` varchar(50) DEFAULT NULL,
  `siswatgllahir` date DEFAULT NULL,
  `siswastatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `siswa` */

insert  into `siswa`(`nis`,`siswanama`,`siswajekel`,`siswatmplahir`,`siswatgllahir`,`siswastatus`) values 
('0989870','Juminten','Perempuan','Padang','2000-09-08',1),
('0989878','Udin','Laki-laki','Pangian','1986-09-08',1),
('0989879','Umar Kudin','Laki-laki','Padang','2000-02-04',1);

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `judul_slider` varchar(50) DEFAULT NULL,
  `gambar_slider` text DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `slider` */

insert  into `slider`(`idx`,`judul_slider`,`gambar_slider`,`aktif`) values 
(1,'Slider 1','files/slider/2021/slider__1_SLIDER_28062020_img_mountains_wide.jpg',1),
(2,'Slider 2','files/slider/2021/slider__1_SLIDER_28062020_img_nature_wide.jpg',1),
(3,'Slider 3','files/slider/2021/slider__1_SLIDER_28062020_img_snow_wide.jpg',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `idx_level` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`idx`,`idx_level`,`username`,`password`,`email`,`nama_lengkap`,`aktif`) values 
(1,1,'su','0b180078d994cb2b5ed89d7ce8e7eea2','su@admin.com','Super Admin',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
