<?php 
	echo 'başarılı';
	/*
	require "keyb.notification.php";
	
	$bildirim = new notification();
	
	//Okunmamış olan Bildirimleri listeletiyoruz
	if(isset($_GET['durum'],$_POST['kime'],$_POST['guvenlik']) and !empty($_GET['durum'])){
		
		$durum = trim(strip_tags($_GET['durum']));
		$kime = trim(strip_tags($_POST['kime']));
		$postguvenlik = trim(strip_tags($_POST['guvenlik']));
		
		
		if($durum=='listele'){
			
			$degerler = array(
				'kime' => $kime,
				'guvenlik' => $postguvenlik,
			);
			
			$bildirim->bildirimlistele($degerler);
			
		}else if($durum=='sonbildirim'){
			
			$degerler = array(
				'kime' => $kime,
				'guvenlik' => $postguvenlik,
			);
			
			$bildirim->bildirimal($degerler);
			
		}else if($durum=='bildirimkayitet' and isset($_POST['bildirim'],$_POST['kime'],$_POST['guvenlik'],$_POST['kimden'])){
						
			$bildirimy = trim(strip_tags($_POST['bildirim']));
			$kimden = trim(strip_tags($_POST['kimden']));
			

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
	*/