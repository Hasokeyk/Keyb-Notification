<?php 
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/x-javascript');
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
	
	require "keyb.notification.php";
	
	$bildirim = new notification();
	
	//Okunmamış olan Bildirimleri listeletiyoruz
	if(isset($_GET['durum'],$_POST['kime'],$_POST['kimden'],$_POST['guvenlik']) and !empty($_GET['durum'])){
		
		$durum = trim(strip_tags(htmlspecialchars($_GET['durum'])));
		$kime = trim(strip_tags(htmlspecialchars($_POST['kime'])));
		$kimden = trim(strip_tags(htmlspecialchars($_POST['kimden'])));
		$postguvenlik = trim(strip_tags(htmlspecialchars($_POST['guvenlik'])));
		
		if($durum=='listele'){
			
			$degerler = array(
				'kime' => $kime,
				'guvenlik' => $postguvenlik,
			);
			
			$bildirim->bildirimlistele($degerler);
			
		}else if($durum=='sonbildirim'){
						
			$degerler = array(
				'kimden' => $kimden,
				'guvenlik' => $postguvenlik,
			);
			
			$bildirim->bildirimal($degerler);
			
		}else if($durum=='bildirimkayitet' and isset($_POST['bildirim'],$_POST['kime'],$_POST['guvenlik'],$_POST['kimden'])){
			
			$bildirimy = trim(strip_tags(htmlspecialchars($_POST['bildirim'])));
			
			$degerler = array(
				'bildirim' => $bildirimy,
				'tarih' => (time()),
				'kime' => $kime,
				'kimden' => $kimden,
				'guvenlik' => $postguvenlik,
			);
			
			$bildirim->bildirimkayit($degerler);
			
		}
		
	}
	
