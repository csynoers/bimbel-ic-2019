<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../josys/koneksi.php";
include "../../../josys/fungsi_thumb.php";

$module=$_GET[module];
$act=$_GET[act];

// Update sosmed
if ($module=='logosiswalolos' AND $act=='update'){
		
		  $lokasi_file    = $_FILES['fupload']['tmp_name'];
		  $tipe_file      = $_FILES['fupload']['type'];
		  $nama_file      = $_FILES['fupload']['name'];
		  $acak           = rand(000000,999999);
		  $nama_file_unik = $acak.$nama_file; 
		  
		if(!empty($lokasi_file)){
			
			if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/gif" AND $tipe_file != "image/png"){?>
		    <script>window.alert("Upload Gagal, Pastikan File yang di Upload bertipe *.JPG, *.GIF, *.PNG");
		        window.location=("../../media.php?module=<?php echo $module.'&act=edit&id='.$_POST['id'] ?>")</script>;
		    <?php die();}
		  
			$tampil=mysql_query("SELECT * FROM logosiswalolos WHERE id_logosiswalolos='$_POST[id]'");
			$ex=mysql_fetch_array($tampil);
				if($ex['gambar'] != ''){
					unlink("../../../joimg/linkterkait/$ex[gambar]");
				}
			
			UploadLinkterkait($nama_file_unik);

			mysql_query("UPDATE logosiswalolos SET 	nama 	= '$_POST[nama]',
											link 	= '$_POST[link]',
											gambar = '$nama_file_unik',
											status_link = '$_POST[status]'
		                            WHERE id_logosiswalolos  = '$_POST[id]'");
		                          //  echo $sql; exit;
		}
		else{
			mysql_query("UPDATE logosiswalolos SET 	nama = '$_POST[nama]', link = '$_POST[link]',status_link = '$_POST[status]'
								WHERE id_logosiswalolos = '$_POST[id]'");
		}
  header('location:../../media.php?module='.$module);
}
// Hapus Sosmed
if ($module=='logosiswalolos' AND $act=='hapus'){

		$tampil=mysql_query("SELECT * FROM logosiswalolos WHERE id_logosiswalolos='$_GET[id]'");
		$ex=mysql_fetch_array($tampil);

		if($ex[gambar] != ''){
			unlink("../../../joimg/linkterkait/$ex[gambar]");
			mysql_query("DELETE FROM logosiswalolos WHERE id_logosiswalolos='$_GET[id]'");
		}else{
			mysql_query("DELETE FROM logosiswalolos WHERE id_logosiswalolos='$_GET[id]'");
		}
		header('location:../../media.php?module='.$module);
}

// Update Tambah sosmed
if ($module=='logosiswalolos' AND $act=='insertnew'){
/*  
	mysql_query("INSERT INTO sosmed(nama,
									link) 
                            VALUES('$_POST[nama]',
									'$_POST[link]')");
	header('location:../../media.php?module='.$module);
*/
		  	$lokasi_file    = $_FILES['fupload']['tmp_name'];
			$tipe_file      = $_FILES['fupload']['type'];
			$nama_file      = $_FILES['fupload']['name'];
			$acak           = rand(000000,999999);
			$nama_file_unik = $acak.$nama_file; 

			if(!empty($lokasi_file)){

			if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg" AND $tipe_file != "image/gif" AND $tipe_file != "image/png"){?>
			<script>window.alert("Upload Gagal, Pastikan File yang di Upload bertipe *.JPG, *.GIF, *.PNG");
			    window.location=("../../media.php?module=<?php echo $module.'&act=edit&id='.$_POST['id'] ?>")</script>;
			<?php die();}

			UploadLinkterkait($nama_file_unik);
	  
				mysql_query("INSERT INTO logosiswalolos(nama,
										link, gambar,status_link) 
								VALUES('$_POST[nama]', '$_POST[link]', '$nama_file_unik','$_POST[status]')");
								//echo $sql; exit();
		}else{
			mysql_query("INSERT INTO logosiswalolos(nama, link, status_link) 
								VALUES('$_POST[nama]', '$_POST[link]','$_POST[status]')");
		}
		
		header('location:../../media.php?module='.$module);
}

}
?>