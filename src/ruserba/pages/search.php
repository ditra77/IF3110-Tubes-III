<?php 
	if(!isset($_SESSION['username'])) {
		header("Location: /ruserba");
	} else if ($_SESSION['username'] == 'admin') {
		header("Location: /ruserba/pages/listkategori.php");
	}
?>
<script src='/ruserba/scripts/addtocart.js'></script>
<?php
	$q = urldecode($_GET['q']);
	$r = urldecode($_GET['r']);
	if($r=="nama"){
		$barangs = simplexml_load_file($rest."/barang?nama_barang%20like%20'%".$q."%'.xml");
	} else if ($r=="harga") {
		$barangs = simplexml_load_file($rest."/barang?harga_barang%20like%20'%".$q."%'.xml");
	} else if ($r=="kategori") {
		$kategoris = simplexml_load_file($rest."/kategori?nama_kategori%20like%20'%".$q."%'.xml");
		if(count($kategoris->children())>0) {
			$barangs = simplexml_load_file($rest."/barang?id_kategori=".$kategoris->children().".xml");
		} else {
			$barangs = simplexml_load_file($rest."/barang?id_kategori=-1.xml");
		}
	}
	$banyakBarang = count($barangs->children());
	$page = isset($_GET['p']) ? $_GET['p'] : 1;
	$limit = 10;
	$mulai_dari = $limit * ($page - 1);
	if($r=="nama"){
		$barangs = simplexml_load_file($rest."/barang?nama_barang%20like%20'%".$q."%'%20order%20by%20nama_barang%20limit%20".$mulai_dari.",%20".$limit.".xml");
	} else if ($r=="harga") {
		$barangs = simplexml_load_file($rest."/barang?harga_barang%20like%20'%".$q."%'%20order%20by%20nama_barang%20limit%20".$mulai_dari.",%20".$limit.".xml");
	} else if ($r=="kategori") {
		$kategoris = simplexml_load_file($rest."/kategori?nama_kategori%20like%20'%".$q."%'.xml");
		if(count($kategoris->children())>0) {
			$barangs = simplexml_load_file($rest."/barang?id_kategori=".$kategoris->children()."%20order%20by%20nama_barang%20limit%20".$mulai_dari.",%20".$limit.".xml");
		} else {
			$barangs = simplexml_load_file($rest."/barang?id_kategori=-1.xml");
		}
	}
	echo '<h3 class="judul_halaman">';
	echo 'Hasil pencarian untuk: '.$q.' ('.($mulai_dari + 1).'-'.($mulai_dari + count($barangs)).' dari '.$banyakBarang.' hasil)';
	echo '</h3>';
	if (count($barangs->children()) > 0) {
		foreach ($barangs->children() as $child) {
			$barang = simplexml_load_file($rest."/barang/".$child.".xml");
			echo '<div class="halaman_category_container">';
			echo '<div class="barang_container">';
			echo '<div class="barang">';
			echo '<a href="/ruserba/barang/'.$barang->id_barang.'">';
			echo '<img src="/ruserba/assets/barang/'.$barang->gambar.'" height="100%"/>';
			echo '</a>';
			echo '</div>';
			echo '<div class="barang">';
			echo '<span class="barang_nama">';
			echo '<a href="/ruserba/barang/'.$barang->id_barang.'">';
			echo $barang->nama_barang;
			echo '</a>';
			echo '<br/>';
			echo 'Kategori: ';
			echo '<a href="/ruserba/kategori/'.$barang->id_kategori.'">';
			$kategori = simplexml_load_file($rest."/kategori/".$barang->id_kategori.".xml");
			echo $kategori->nama_kategori;
			echo '</a>';
			echo '</span>';
			echo '<br>';
			if($barang->tersedia==0){
				echo '<span class="barang_tersedia">';
				echo 'Barang tidak tersedia';
				echo '</span>';
				echo '<br>';
			}
			else{
				echo '<span class="barang_tersedia">';
				echo 'Barang tersedia ('.$barang->tersedia.' 	unit)';
				echo '</span>';
				echo '<br>';
			}
			echo '<span class="barang_harga">';
			echo 'Rp '.$barang->harga_barang.',00';
			echo '</span>';
			echo '<br>';
			echo '</div>';
			if ($barang->tersedia > 0) {
				echo '<a class="button beli" name="'.$barang->id_barang.'" href="javascript:void(0)"><div>Pesan Barang</div></a>';
			}
			echo '</div>';
			echo '</div>';
			echo '<hr>';
		}
	}
	//membuat pagination
	$banyakHalaman = ceil($banyakBarang / $limit);
	if ($banyakHalaman > 1) {
		echo '<div class="paginasi">';
		echo 'Halaman: ';
		for($i = 1; $i <= $banyakHalaman; $i++){
			if($page != $i){
				echo '<a href="/ruserba/search/'.$_GET['q'].'/'.$_GET['r'].'/'.$i.'">['.$i.']</a> ';
			}
			else {
				echo "[$i] ";
			}
		}
	}
	echo '</div>';
?>