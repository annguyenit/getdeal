// ****  Time Zone Count Down Javascript  **** //
/*
	Visit http://rainbow.arch.scriptmania.com/scripts/
	for this script and many more
*/

////////// CONFIGURE THE COUNTDOWN SCRIPT HERE //////////////////

//function start() {displayTZCountDown(setTZCountDown(month,day,hour,tz),lab);}

// **    The start function can be changed if required   **
//window.onload = start;

////////// DO NOT EDIT PAST THIS LINE //////////////////

function setTZCountDown(month,day,hour,min,second,tz,expdate) 
{	
	//console.log('log-start');
	//console.log(month + ' - ' + day + ' - ' + hour + ' - ' + min + ' - ' + second + ' - ' + tz + ' - ' + expdate);
	var toDate = new Date();
	toDate.setHours(parseInt(hour,10));
	toDate.setMinutes(parseInt(min,10)-(parseInt(tz,10)*60));
	toDate.setSeconds(parseInt(second,10));
	
	
	if (month == '*'){
		toDate.setMonth(toDate.getMonth() + 1);		
	}else if (parseInt(month,10) > 0){ 	
		if (parseInt(month,10) <= toDate.getMonth()){
			toDate.setYear(toDate.getYear() + 1);
		}
		toDate.setMonth(parseInt(month,10)-1);
	}
	
	if (day.substr(0,1) == '+'){
		var day1 = parseInt(day.substr(1),10);
		toDate.setDate(toDate.getDate()+day1);
	} 
	else{
		toDate.setDate(parseInt(day,10));
	}
	
	
	var fromDate = new Date();		
	//console.log(fromDate);
	//console.log(toDate);
	//console.log('log-end');
	var day_off1 = toDate.getDay();
	var day_off2 = fromDate.getDay();
	
	if(day_off2 == day_off1){
		fromDate.setMinutes(fromDate.getMinutes());
		}else{
		fromDate.setMinutes(fromDate.getMinutes() + fromDate.getTimezoneOffset());
	}
	
	var diffDate = new Date(0); 	
	diffDate.setMilliseconds(toDate - fromDate);
	return Math.floor(diffDate.valueOf()/1000);
}
function displayTZCountDown(countdown,tzcd,exp,expdate)
{
	
	if (countdown < 0) {
		
		document.getElementById(exp).style.display='none';
		document.getElementById(tzcd).innerHTML = "<div class='i_expire'><span>DEZE DEAL IS VERLOPEN</span></div>";
	}
	else {
		var oneDay=60*60*24 //day unit in seconds
		
		var secs = countdown % 60; 
		if (secs < 10) secs = '0'+secs;
		var countdown1 = (countdown - secs) / 60;
		var mins = countdown1 % 60; 
		if (mins < 10) mins = '0'+mins;
		countdown1 = (countdown1 - mins) / 60;
		var hours = countdown1 % 24;
		var days = Math.floor(countdown /(oneDay));
		//document.getElementById(tzcd).innerHTML = "<ul class='deal_box'><li class='title_text2'>DEAL<br />ENDS IN:</li><li> "+days + "<small>Days</small></li><li>" + (days == 1 ? '' :'') +hours+ '<small>Hours</small></li><li>' +mins+ '<small>minutes</small></li><li>'+secs+'<small>seconds</small></li></ul>';
		document.getElementById(tzcd).innerHTML = "<div class='mp_deal_box'>NOG: <span class='hour'>"+hours+"</span> UUR <span class='min'>"+mins+ "</span> MIN <span class='sec'>" +secs+'</span> SEC</div>';
		
		setTimeout('displayTZCountDown('+(countdown-1)+',\''+tzcd+'\');',999);
	}
}