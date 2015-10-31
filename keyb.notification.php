<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/x-javascript');
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
	
	/*
		Hasan Yüksektepe
		26.10.2015
		
		Sunucuyu yormadan başka bir sunucu ile anlık bildirim sistemi
		
	*/
	
	$guvenlik = 'hasan'; //LÜTFEN BURAYa KENDİNİZE AİT BİR GÜVENLİK KODU GİRİNİZ
	
	class notification {
		
		private $guvenlik = 'hasan';
		private $hata = '';
		private $sonuc = array();
		private $listele = array();
		
		/*
			$degerler = array(
				'bildirim' => 'Bildirim yazısı',
				'zaman' => '145478545',
				'kime' => '1',
				'kimden' => '1',
				'grup' => '1',
			);
		*/
		
		function __construct(){
			
			//Klasör kontrol
			if(file_exists('bildirimler')===false){
				mkdir('bildirimler',0777);
			}
			
		}
		
		//Gelen bildirimin kayıt olması
		function bildirimkayit($degerler){
			
			//Güvenlik Kontrol
			if($degerler['guvenlik']==$this->guvenlik){
				
				//kime aitse onun adında dosya açıp bilgileri yazdırıyor
				$ac = fopen('bildirimler/'.$degerler['kime'].'.txt','a');
				$yaz = json_encode(array(
					'kime' => $degerler['kime'],
					'bildirim' => $degerler['bildirim'],
					'tarih' => $degerler['tarih'],
					'kimden' => $degerler['kimden'],
					'okunma' => '0',
				));
				fwrite($ac,$yaz."\n");
				fclose($ac);
				if($ac){
					$this->sonuc = 'Başarılı';
				}else{
					$this->hata = 'Dosya Yazılamadı';
				}
				
			}else{
				$this->hata = 'Güvenlik Hatası';
			}
			
		}
		
		//Okunmamış olan bildirimleri listeletiyoruz
		function bildirimlistele($degerler){
			
			//Güvenlik Kontrol
			if($degerler['guvenlik']==$this->guvenlik){
				
				$satirlar = file('bildirimler/'.$degerler['kime'].'.txt');
				foreach($satirlar as $satir){
					$sat = json_decode($satir);
					if($sat->okunma=='0'){
						$this->listele[] = json_decode($satir);
					}
				}
				
				$this->sonuc = $this->listele;
				
			}else{
				$this->hata = 'Güvenlik Hatası';
			}
			
		}
		
		//son bildirimi alıyoruz
		function bildirimal($degerler){
			
			//Güvenlik Kontrol
			if($degerler['guvenlik']==$this->guvenlik){
				
				$satirlar = file('bildirimler/'.$degerler['kime'].'.txt');
				$sonveri = json_decode(end($satirlar));
				
				if($sonveri->okunma=='0'){
					$this->listele[] = json_decode(end($satirlar));
				}else{
					$this->listele[] = 'yok';
				}
				$this->sonuc = $this->listele;
			}else{
				$this->hata = 'Güvenlik Hatası';
			}
			
		}
		
		//giden bildirimin okuduğunu ayarlıyoruz
		function bildirimokundu($degeler){
			
			//Güvenlik Kontrol
			if($degerler['guvenlik']==$this->guvenlik){
				
				$satirlar = file('bildirimler/'.$degerler['kime'].'.txt');
				
				foreach($satilar as $line => $satir){
					if($satir=='{"kime":"'.$degerler['kime'].'","bildirim":"'.$degerler['deneme'].'","tarih":'.$degerler['tarih'].',"kimden":"'.$degerler['kimden'].'","okunma":"0"}'){
						str_replace($satir,'{"kime":"'.$degerler['kime'].'","bildirim":"'.$degerler['deneme'].'","tarih":'.$degerler['tarih'].',"kimden":"'.$degerler['kimden'].'","okunma":"1"}',$satirlar);
					}
				}
				
			}else{
				$this->hata = 'Güvenlik Hatası';
			}
			
		}
		
		//Bildirim temizleme
		function bildirimsil($degerler){
			
			//Güvenlik Kontrol
			if($degerler['guvenlik']==$this->guvenlik){
				
				unset('bildirimler/'.$degerler['kime'].'.txt');
				
			}else{
				$this->hata = 'Güvenlik Hatası';
			}
			
		}
		
		//Class tamamlandıktan sonra hata ve sonuc çıktısı
		function __destruct(){
			if(empty($this->hata)){
				$sonuc['durum'] = $this->sonuc;
			}else{
				$sonuc['hata'] = $this->hata;
			}
		    echo json_encode(array($sonuc));
	   }
		
	}
	
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