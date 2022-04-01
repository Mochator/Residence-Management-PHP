//Information form

document.write('<div class="information" id="information"><p><b id="information-title"></b></p><p id="information-content"></p><button class="close" onclick="closeForm(\'information\')">OK</button></div>');
document.write('<div class="error" id="error"><p><b id="error-title"></b></p><p id="error-content"></p><button class="close" onclick="closeForm(\'error\')">OK</button></div>');

function closeForm(x){
	document.getElementById(x).style.display = "none";
}