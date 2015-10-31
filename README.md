# Anlık Bildirim Eklentisi
Bu eklenti ile kendi sunucunuzu yormadan başka bir sunucu ile anlık bildirim sistemi yazabilirsiniz.

#Hızlı Kurulum için
[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

1. Butona Tıklayın ve heroku.com'dan üye olun veya üye girişi yapın.
2. Eklentinin kurulum ekranında size özel verilecek olan domainin ismini seçin ÖRN: bildirim.heroku.com
3. Size verilen domain ile artık anlık bildirim sistemini çalıştırabilirsiniz

# AJAX İLE VERİ ÇEKME

<pre>
var sonbildirim = '';
setInterval(function(){
	var kime = 'hasan';
	var guvenlik = 'hasan';
	$.ajax({  
		type : 'POST',
		url : '-{HEROKU SİTENİZİN ADRESİ}-?durum=sonbildirim',  
		data : 'kime='+kime+'&guvenlik='+guvenlik,
		crossOrigin: false,
		async : true,
		dataType : 'json',
		success : function(data, textStatus, jqXHR) {
			if(sonbildirim!=data[0].durum[0].bildirim){
				$('.durum').append(
				'<span>KİME : '+data[0].durum[0].kime+'</span> <br />'+
				'<span>KİMDEN : '+data[0].durum[0].kimden+'</span> <br />'+
				'<span>BİLDİRİM : '+data[0].durum[0].bildirim+'</span> <br />'+
				'<span>TARİH : '+data[0].durum[0].tarih+'</span> <br />'
				);
				sonbildirim = data[0].durum[0].bildirim;
			}
		},
		error : function(jqXHR, textStatus, errorThrown) {  
			console.log(textStatus);  
		}  
	});
},1000);
</pre>

Yukarıdaki ajax kodu ile her 1sn de bir oluşturduğunuz domaine sorgu yaparak son yollanan bildirimi alır.

## Değiştirmeniz gereken yerler
1. -{HEROKU SİTENİZİN ADRESİ}- yazan yere oluşturduğunuz domain adresi gelecek
2. var kime = 'hasan'; bu koddaki sadece hasan kişisine giden bildirimleri alır.
3. var guvenlik = 'hasan'; burası yolladığınız bildirimlerin güvenlliğini sağlamak içindir düzenlemek istiyorsanız aşağıdaki videoyu izleyebilirsiniz.

# AJAX VERİ YOLLAMA

<pre>
var bildirimal = 'test bildirim';
var kime = 'hasan';
var kimden = 'hasokeyk';
var guvenlik = 'hasan';
$.ajax({  
	type : 'POST',  
	url : '-{HEROKU SİTENİZİN ADRESİ}-?durum=bildirimkayitet',  
	data : 'kime='+kime+'&bildirim='+bildirimal+'&kimden='+kimden+'&guvenlik='+guvenlik,
	crossOrigin: false,
	async : true,  
	//contentType : "application/x-javascript",  
	dataType : 'json',
	//jsonp:  "durum",  
	//jsonpCallback: 'bildirim',  
	success : function(data, textStatus, jqXHR) {
		//console.log(data[0].sonuc);
	},
	error : function(jqXHR, textStatus, errorThrown) {  
		//console.log(textStatus);  
	}  
});
</pre>

## Değiştirmeniz gereken yerler
1. -{HEROKU SİTENİZİN ADRESİ}- yazan yere oluşturduğunuz domain adresi gelecek
2. var kime = 'hasan'; bu koddaki sadece hasan kişisine giden bildirimleri atar.
3. var kimden = 'hasokeyk'; bu koddaki bildirim kimden gideceğini belirtir
4. var bildirimal = 'test bildirim'; bu kodda bilirimin yazısı belirtilmelidir
5. var guvenlik = 'hasan'; burası yolladığınız bildirimlerin güvenlliğini sağlamak içindir düzenlemek istiyorsanız aşağıdaki videoyu izleyebilirsiniz.
