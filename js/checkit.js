function checkIt(evt) {
	evt = (evt) ? evt : window.event
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46 && charCode!=45) 
	{
		status = "This field accepts numbers only."
		return_val = false
	}
	else
	{
		  status = ""
		  return_val = true
	}
	return return_val
}