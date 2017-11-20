function display(id,status) {
	document.getElementById(id).style.display=status;
}

function clearInput(id) {
	document.getElementById(id).value="";
}

function getValueById(id) {
	return document.getElementById(id).value;
}

function pwdConfirmation() {
    var message, pwd, pwdconfirm;
    pwd = document.getElementById("pwd").value;
	pwdconfirm = document.getElementById("pwdconfirm").value;
    msgtext.innerHTML = "";
    try { 
        if(pwd!=pwdconfirm)   {
			display('msg','block');
			clearInput('pwd');
			clearInput('pwdconfirm');
			throw " Το συνθηματικό δεν συμπίπτει με την επιβεβαίωση συνθηματικού";
		}	else {
			display('msg','none');
		}
    } catch(err) {
        msgtext.innerHTML = "<strong>Προσοχή!</strong>" + err;
    }
}

function upperCase(id) {
	var str = document.getElementById(id).value;
	document.getElementById(id).value = str.toUpperCase();
}

function emailValidation(id){
	var str = document.getElementById(id).value;
	var pattern = new RegExp("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$");
	try {
		if(pattern.test(str)){
			display('msg','none');
		} else {
			display('msg','block');
			throw " Η ηλεκτρονική διεύθυνση (email) δεν είναι έγκυρη";
		}
	} catch(err) {
		msgtext.innerHTML ="<strong>Προσοχή!</strong>" + err;
	}
}

function k_fValidation(id){
	var str = document.getElementById(id).value;
	var pattern = new RegExp("[0-9]{8}");
	try {
		if((str=="")||(pattern.test(str))){
			display('msg','none');
		} else {
			display('msg','block');
			throw " Μη έγκυρο μητρώο. Το μητρώο αποτελείται από οκτώ ψηφία";
		}
	} catch(err) {
		msgtext.innerHTML ="<strong>Προσοχή!</strong>" + err;
	}
}
