function closeDialogBox(boxId)
{
	document.getElementById(boxId).style.cssText='display: none;';
}
function showDialogBox(boxId)
{
	document.getElementById(boxId).style.cssText='display: block';
}

function clearConfirmActionBox()
{
	document.getElementById('confirm-action-text').innerHTML='';
	document.getElementById('action-confirm').setAttribute('onclick', '');
}