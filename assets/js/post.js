function deletePost(id)
{
	if (confirm("Apakah Anda yakin menghapus post ini?"))
	{
		var xmlHtppObj = new XMLHttpRequest();
		xmlHtppObj.open("POST", "delete_post.php", true);
		xmlHtppObj.onreadystatechange = function()
		{
			if ((xmlHtppObj.status == 200) && (xmlHtppObj.readyState == 4))
			{
				alert(xmlHtppObj.responseText);
				location.reload();
			}
		}
		xmlHtppObj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlHtppObj.send("id=" + id);
	}

	return false;
}

function deleteImagePost(id)
{
	if (confirm("Apakah Anda yakin menghapus post ini?"))
	{
		var xmlHtppObj = new XMLHttpRequest();
		xmlHtppObj.open("POST", "delete_image_post.php", true);
		xmlHtppObj.onreadystatechange = function()
		{
			if ((xmlHtppObj.status == 200) && (xmlHtppObj.readyState == 4))
			{
				alert(xmlHtppObj.responseText);
				location.reload();
			}
		}
		xmlHtppObj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlHtppObj.send("id=" + id);
	}

	return false;
}

function validate()
{
	var re = /^(\d{1,2})-(\d{1,2})-(\d{4})$/;
	var dateField = document.getElementById("Tanggal");
	var errorMessage = document.getElementById("errorMessage");

	if ((re.test(dateField.value)) && (dateField.value != ''))
	{
		dateString = dateField.value.split("-");

		date = new Date(dateString[2], dateString[1] - 1, dateString[0], 23, 59, 59);
		currentDate = new Date();

		if (date <= currentDate)
		{
			errorMessage.innerHTML = "Tanggal harus lebih baru atau sama dengan hari ini";
			return false;
		} else {
			errorMessage.innerHTML = "";
			return true;
		}

	}else {
		
		errorMessage.innerHTML = "Format tanggal adalah DD-MM-YYYY";
		return false;
	}
}