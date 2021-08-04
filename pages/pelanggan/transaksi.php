<?php
session_start();

require_once '../../functions.php';

$dp=$_SESSION["nama_pelanggan"];
$dpp=$_SESSION["id_pelanggan"];

if (!isset($_SESSION['cart'])) {
 header('Location: index.php');
}

$cart = unserialize(serialize($_SESSION['cart']));
$total_item = 0;
$total_bayar = 0;

// proses penyimpanan data ke tabel PESANAN
for ($i=0; $i<count($cart); $i++) { 
 $total_item = $cart[$i]['qty'];
 $total_bayar = $cart[$i]['qty'] * $cart[$i]['price'];
 $iddd = $cart[$i]['id'];
 $query = mysqli_query($conn, "INSERT INTO pesanan (jumlah_pesanan, total_harga, tanggal, id_pelanggan, id_menu) VALUES ('$total_item', '$total_bayar', '" . date('Y-m-d') . "','$dpp', '$iddd')");
}

// proses penyimpanan data ke tabel PEMBAYARAN
$id_order = mysqli_insert_id($conn);
for ($i=0; $i<count($cart); $i++) { 
$tb += $cart[$i]['qty'] * $cart[$i]['price'];

 $query = mysqli_query($conn, "INSERT INTO pembayaran (total_pembayaran, tgl_pembayaran, id_pesanan, id_pelanggan, status) VALUES ('$tb', '" . date('Y-m-d') . "', '$id_order','$dpp', 2)");
}

// unset session
unset($_SESSION['cart']);
$_SESSION['pesan'] = "<a href='bayar.php'>Pembelian sedang diproses, terima kasih. Silakan ke menu <b>Riwayat Pesanan</b> untuk melakukan pembayaran.</a>";
header('Location: index.php');