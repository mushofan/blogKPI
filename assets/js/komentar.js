function validate()
{
	var email = document.getElementById("Email").value;

	var regularExpression = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	var errorMessage = document.getElementById("errorMessage");
	if (regularExpression.test(email))
	{
		errorMessage.innerHTML = "";
		return true;
	} else {
		
		errorMessage.innerHTML = "Alamat email yang anda masukkan tidak valid<br/>";
		return false;
	}

}


function tambahKomentar(nama, tanggal, komentar)
{
	var ajaxComment = document.getElementById("ajaxComment");

	var li = document.createElement("li");
	li.setAttribute("class", "art-list-item");
	ajaxComment.appendChild(li);

	var div1 = document.createElement("div");
	div1.setAttribute("class", "art-list-item-title-and-time");
	li.appendChild(div1);

	var h2 = document.createElement('h2');
	h2.setAttribute("class", "art-list-title");
	h2.innerHTML = nama;
	div1.appendChild(h2);
	
	var div2 = document.createElement("div");
	div2.setAttribute("class", "art-list-time");
	div2.innerHTML = tanggal;
	div1.appendChild(div2);

	var p = document.createElement("p");
	p.innerHTML = komentar;
	li.appendChild(p);
}

function sendKomentar()
{
	var xmlHttpObj = new XMLHttpRequest();
	if (validate())
	{
		xmlHttpObj.open("POST", "komentar.php",true);
		xmlHttpObj.onreadystatechange = function()
		{
			if ((xmlHttpObj.status == 200) && (xmlHttpObj.readyState == 4))
			{
				var komentar = JSON.parse(xmlHttpObj.responseText);
				tambahKomentar(komentar['nama'], komentar['tanggal'], komentar['komentar']);
			}
		}
		xmlHttpObj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		var param = "nama=" + encodeURIComponent(document.getElementById("Nama").value) + 
			"&email=" + encodeURIComponent(document.getElementById("Email").value) + 
			"&komentar=" + encodeURIComponent(document.getElementById("Komentar").value) + 
			"&id=" + encodeURIComponent(document.getElementById("pageId").value) + 
			"&submit=Kirim"
		xmlHttpObj.send(param);
		
	} else {
		return false;
	}
}

function getParam( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return null;
  else
    return results[1];
}

function loadSemuaKomentar()
{
	var xmlHttpObj = new XMLHttpRequest();
	xmlHttpObj.open("GET", "komentar.php?id=" + getParam("id"), true);
	xmlHttpObj.onreadystatechange = function()
	{
		if ((xmlHttpObj.status == 200) && (xmlHttpObj.readyState == 4))
		{

			var i;
			var komentar = JSON.parse(xmlHttpObj.responseText);
			for (i=0; i < komentar.length; i++)
			{
				tambahKomentar(komentar[i]['nama'], komentar[i]['tanggal'], komentar[i]['komentar']);
			}
		}
	}
	xmlHttpObj.send();
}