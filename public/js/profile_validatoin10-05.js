function submitTeacherProfile() {
	var requiredValues = [document.dataDisplay.firstName.value, document.dataDisplay.lastName.value, document.dataDisplay.email.value];
	var cleared = true;
	var i = -1; while (++i<requiredValues.length) {
		if ((requiredValues[i]=="") ||
			(requiredValues[i]==" ") ||
			(requiredValues[i]==null) ||
			(requiredValues[i]=="undefined")
			) {
			alert("First Name, Last Name and Email are required entries\nPlease check your input.\nThis form cannot be submitted.");
			cleared = false;
			break;
		}
	}
	if (cleared)	return true;
	else	return false;
}

function trimString(str) {
	str = this != window? this : str;
	return str.replace(/^\s+/g, '').replace(/\s+$/g, '');
}

function checkNumeric(objName) {
	var numberfield = objName;
	if (chkNumeric(objName) == false) {
		numberfield.select();
		numberfield.focus();
		return false;
	}
	else	return true;
}

function isZip(s){
	s = s.value;
    reZip = new RegExp(/(^\d{5}$)|(^\d{5}-\d{4}$)/);
    if(!reZip.test(s)){
         alert("Zip Code Is Not Valid");
         return false;
    }
	return true;
}

function chkNumeric(objName) {
	// only allow 0-9 be entered, plus any values passed
	var checkOK = "0123456789,.-";
	var checkStr = objName;
	var allValid = true;
	var decPoints = 0;
	var allNum = "";
	if (checkStr.value=="") return false;
	if (parseInt(checkStr.value)!=checkStr.value) {
		alertsay = "Please enter only numeric values\n \""
		alertsay = alertsay + checkOK + "\" in this field."
		alert(alertsay);
		return (false);
	}
	else	return true;
/*	for (i = 0;  i < checkStr.value.length;  i++) {
		ch = checkStr.value.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		if (ch == checkOK.charAt(j))
		break;
		if (j == checkOK.length) {
		allValid = false;
		break;
		}
		if (ch != ",")
		allNum += ch;
		}
		if (!allValid)
		{
		alertsay = "Please enter only numeric values\n \""
		alertsay = alertsay + checkOK + "\" in this field."
		alert(alertsay);
		return (false);
		}
*/
}