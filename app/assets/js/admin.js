	function AppliquerCourriel() {
		var champs = new Array('input_email_from_name','input_email_from_email','input_email_replyto_name','input_email_replyto_email');
		var compte = 0;
		var intro = CachonsEditor(7);
		var bye = CachonsEditor(8);
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte == 0 && intro == IntroInital && bye == TxByeInital) { return false; }
		for (x=0; x<champs.length; x++) {
			document.getElementById(champs[x]).style.backgroundColor = 'red';
		}

		var xhttp = new XMLHttpRequest();
		var formdata = new FormData();
		formdata.append("fName", document.getElementById('input_email_from_name').value);
		formdata.append("fMail", document.getElementById('input_email_from_email').value);
		formdata.append("rName", document.getElementById('input_email_replyto_name').value);
		formdata.append("rMail", document.getElementById('input_email_replyto_email').value);
		formdata.append("intro", document.getElementById('input_email_replyto_email').value);
		formdata.append("intro", intro);
		formdata.append("bye", bye);
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					//alert(xhttp.responseText);
					IntroInital = intro; 
					TxByeInital = bye;
					Verdissons(champs,xhttp.responseText);
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
	}
	
	function AppliquerPrefGen() {
		champs = new Array('input_coula','input_coulb','input_coulc','input_could','input_coule','input_coulo','input_duree','input_prog','input_test');
		if (!VerifChamps(champs)) { return false; }

		var xhttp = new XMLHttpRequest();
		var formdata = new FormData();
		for(x=0; x<champs.length; x++) {
			formdata.append(champs[x].substr(6) , document.getElementById(champs[x]).value);
		}
		var NextPage = 'app/application/controllers/ajax/ChgPrefGen.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					//alert(xhttp.responseText);
					Verdissons(champs,xhttp.responseText);
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
	}
	
	function AppliquerServeur() {
		champs = new Array('input_email_encoding','input_email_linelenght','input_email_server','input_email_port','input_email_encryption','input_email_username','input_email_password','select_Email_transport','select_Email_plainHTML','input_email_mailerrormsg');
		if (!VerifChamps(champs)) { return false; }
		var xhttp = new XMLHttpRequest();
		var formdata = new FormData();
		formdata.append("transport", document.getElementById('select_Email_transport').value);
		formdata.append("plainHTML", document.getElementById('select_Email_plainHTML').value);
		formdata.append("encoding", document.getElementById('input_email_encoding').value);
		formdata.append("linelenght", document.getElementById('input_email_linelenght').value);
		formdata.append("server", document.getElementById('input_email_server').value);
		formdata.append("port", document.getElementById('input_email_port').value);
		formdata.append("encryption", document.getElementById('input_email_encryption').value);
		formdata.append("username", document.getElementById('input_email_username').value);
		formdata.append("password", document.getElementById('input_email_password').value);
		formdata.append("mailerrormsg", document.getElementById('input_email_mailerrormsg').value);
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail_Server.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					//alert(xhttp.responseText);
					Verdissons(champs,xhttp.responseText);
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
	}

	function AppliquerTest(Qui) {
		var champs = new Array('input_email_from_name','input_email_from_email','input_email_replyto_name','input_email_replyto_email');
		var compte = 0;
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte > 0) { alert("Vous devez mettre à jour avant de tester"); return false; }

		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/SendMail.php?Type=TestonsSVP&User=' + Qui;
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					document.getElementById('global-notice').innerHTML = xhttp.responseText;
					document.getElementById('global-notice').style.display = 'block';   
					setTimeout(function(){
						document.getElementById('global-notice').style.display = 'none';   
					}, 7500);
				}
			}
		};
		xhttp.open("GET", NextPage, true);
		xhttp.send(); 
	}

	function ChangeonsText(Quel, Langue, Question) {
		var texte = CachonsEditor(9);
		var Enreg = (Question == 'OUI') ? true : false;
		if (texte != TexteInital && Enreg == false) { Enreg = confirm(Question); }
		var formdata = new FormData();
		formdata.append("Quel", Affiche);
		formdata.append("Enreg", Enreg);
		formdata.append("Prec", texte);
		formdata.append("Suiv", Quel);
		formdata.append("Titre", document.getElementById('input_TitreMsg').value);
		formdata.append("Lang", Langue);
		var xhttp = new XMLHttpRequest();
		var NextPage = 'app/application/controllers/ajax/ChgConfEmail_Textes.php';
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
					Affiche = Quel;
					if (Question == 'OUI') { 
						document.getElementById('global-notice').innerHTML = 'Modification apportée avec succès.  /  Successfully updated.';
						document.getElementById('global-notice').style.display = 'block';   
						setTimeout(function(){
							document.getElementById('global-notice').style.display = 'none';   
						}, 7500); 
					}
					var r = xhttp.responseText;
					var recu = r.split('||');
					TexteInital = recu[0];
					ChangeonsEditor(9, TexteInital);
					document.getElementById('input_TitreMsg').value = recu[1];
				}
			}
		};
		xhttp.open("POST", NextPage, true);
		xhttp.send(formdata); 
	}
	
	function Verdissons(champs,msg) {
		document.getElementById('global-notice').innerHTML = msg;
		document.getElementById('global-notice').style.display = 'block';   
		setTimeout(function(){
			document.getElementById('global-notice').style.display = 'none';   
		}, 7500);
		for (x=0; x<champs.length; x++) {
			document.getElementById(champs[x]).style.backgroundColor = 'green';
		}
		var blanc = setTimeout(function() { for (x=0; x<champs.length; x++) { document.getElementById(champs[x]).style.backgroundColor = 'white'; } }, 5000);
	}

	function VerifChamps(champs) {
		var compte = 0;
		for (x=0; x<champs.length; x++) {
			if (document.getElementById(champs[x]).style.backgroundColor == 'red' ) { return false; }
			if (document.getElementById(champs[x]).style.backgroundColor == 'yellow' ) { compte = compte + 1; }
		}
		if (compte == 0) { return false; }
		for (x=0; x<champs.length; x++) {
			document.getElementById(champs[x]).style.backgroundColor = 'red';
		}
		return true;
	}

	var Affiche = "attached";	
	var IntroInital = ""
	var TexteInital = ""
	var TxByeInital = ""
	setTimeout(function() { IntroInital = CachonsEditor(7); } , 1500);
	setTimeout(function() { TxByeInital = CachonsEditor(8); } , 1500);
	setTimeout(function() { TexteInital = CachonsEditor(9); } , 1500);
