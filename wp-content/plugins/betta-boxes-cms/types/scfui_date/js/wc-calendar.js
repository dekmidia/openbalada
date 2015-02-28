var wcCalendar = {
	init: function (opts) {
		if(!opts.field || !document.getElementById(opts.field)) {
			return false;
		}
		
		document.getElementById(opts.field).readOnly = true;
		
		if(opts.button) {
			document.getElementById(opts.button).onclick = function() {
					var yOff = wcCalendar.getYOffset(opts.field);
					var xOff = wcCalendar.getXOffset(opts.field);
					wcCalendar.showCalendar(opts.field, xOff, yOff, this.value);
			}
		}
		
		if(opts.fieldAsButton === true) {
			document.getElementById(opts.field).onfocus = function() {
					var yOff = wcCalendar.getYOffset(opts.field);
					var xOff = wcCalendar.getXOffset(opts.field);
					wcCalendar.showCalendar(opts.field, xOff, yOff, this.value);
			}
		}
	},
	
	showCalendar: function(fieldId, xOff, yOff, curDate) {
		if(!document.getElementById("wc-calendar")) {
			var myCal = document.createElement("div");
			myCal.setAttribute("id", "wc-calendar");
			var body = document.getElementsByTagName("body");
			
			body[0].appendChild(myCal);
		}else{
			document.getElementById("wc-calendar").style.display = "";
		}
		document.getElementById("wc-calendar").style.left = xOff+"px";
		document.getElementById("wc-calendar").style.top = yOff+"px";
		
		//lets build a calendar in js
		var newDate = null;
		if(curDate) {
			var split = curDate.split(/\-/);
			newDate = new Date();
			newDate.setDate(1);
			newDate.setMonth(parseInt((split[1] - 1))); //month is 0 based in js :|
			newDate.setYear(parseInt(split[0]));
		}

		wcCalendar.drawCalendar(fieldId, newDate);
	},
	
	hideCalendar: function() {
		document.getElementById("wc-calendar").style.display = "none";
	},
	
	drawCalendar:	function(fieldId, useDate) {
		var month = "";
		var firstDay, lastDay; 
		var className = "";
		
		var html = "";
		
		today = new Date();
		
		if(useDate) {
			var date = new Date(useDate);
		}else{
			var date = today;
		}
		
		var firstDayDate = date;
		firstDayDate.setFullYear(firstDayDate.getFullYear(), firstDayDate.getMonth(), 1);
		lastDay = wcCalendar.getLastDay(firstDayDate.getMonth(), firstDayDate.getFullYear());
		firstDay = firstDayDate.getDay();
		
		switch(date.getMonth()) {
		case 0 : month = "January"; break;
		case 1 : month = "Febuary"; break;
		case 2 : month = "March"; break;
		case 3 : month = "April"; break;
		case 4 : month = "May"; break;
		case 5 : month = "June"; break;
		case 6 : month = "July"; break;
		case 7 : month = "August"; break;
		case 8 : month = "September"; break;
		case 9 : month = "October"; break;
		case 10 : month = "November"; break;
		case 11	: month = "December"; break;
		}
		
		html = "<table class='wc-calendar-table'>"+
		"<tr class='wc-cal-header'>"+
		"<td class='border clickable' colspan=2 title='Previous Month' onclick='wcCalendar.moveToDate("+(firstDayDate.getMonth()-1)+", "+firstDayDate.getFullYear()+", \""+fieldId+"\");'>&lt;</td>"+
		"<td colspan='3'>"+
		"<select onchange='wcCalendar.moveToDate(this.value, "+firstDayDate.getFullYear()+", \""+fieldId+"\");' style='text-align:center; width:100%;'>"+
		"<option value='0'"+(date.getMonth() == 0 ? " selected" : "")+">January</option>"+
		"<option value='1'"+(date.getMonth() == 1 ? " selected" : "")+">Febuary</option>"+
		"<option value='2'"+(date.getMonth() == 2 ? " selected" : "")+">March</option>"+
		"<option value='3'"+(date.getMonth() == 3 ? " selected" : "")+">April</option>"+
		"<option value='4'"+(date.getMonth() == 4 ? " selected" : "")+">May</option>"+
		"<option value='5'"+(date.getMonth() == 5 ? " selected" : "")+">June</option>"+
		"<option value='6'"+(date.getMonth() == 6 ? " selected" : "")+">July</option>"+
		"<option value='7'"+(date.getMonth() == 7 ? " selected" : "")+">August</option>"+
		"<option value='8'"+(date.getMonth() == 8 ? " selected" : "")+">September</option>"+
		"<option value='9'"+(date.getMonth() == 9 ? " selected" : "")+">October</option>"+
		"<option value='10'"+(date.getMonth() == 10 ? " selected" : "")+">November</option>"+
		"<option value='11'"+(date.getMonth() == 11 ? " selected" : "")+">December</option>"+
		"</select>"+
		"</td>"+
		"<td class='border clickable' colspan=2 title='Next Month' onclick='wcCalendar.moveToDate("+(firstDayDate.getMonth()+1)+", "+firstDayDate.getFullYear()+", \""+fieldId+"\");'>&gt;</td>"+
		"</tr>"+
		"<tr class='wc-cal-header'>"+
		"<td class='border clickable' colspan=2 title='Previous Year' onclick='wcCalendar.moveToDate("+firstDayDate.getMonth()+", "+(firstDayDate.getFullYear()-1)+", \""+fieldId+"\");'>&lt;</td>"+
		"<td colspan='3'>"+
		"<select onchange='wcCalendar.moveToDate("+firstDayDate.getMonth()+", this.value, \""+fieldId+"\");' style='text-align:center; width:100%;'>";
		todayYear = today.getFullYear();
		
		var startYear = todayYear > date.getFullYear() ? todayYear : date.getFullYear();
		var endYear = 1900 < date.getFullYear() ? 1900 : date.getFullYear();
		
		for(y=startYear; y>=endYear; y--) {
			html += "<option value='"+y+"'"+(date.getFullYear() == y ? " selected" : "")+">"+y+"</option>";
		}
		html +=	"</select>"+
		"</td>"+
		"<td class='border clickable' colspan=2 title='Next Year' onclick='wcCalendar.moveToDate("+firstDayDate.getMonth()+", "+(firstDayDate.getFullYear()+1)+", \""+fieldId+"\");'>&gt;</td>"+
		"</tr>"+
		"<th>Sun</th>"+
		"<th>Mon</th>"+
		"<th>Tue</th>"+
		"<th>Wed</th>"+
		"<th>Thu</th>"+
		"<th>Fri</th>"+
		"<th>Sat</th>";
		
		html += "<tr>";
		var dayCnt = 0;
		if(firstDay > 0) {
			for(dayCnt=0; dayCnt<firstDay; dayCnt++) {
				html += "<td class='empty'>&nbsp;</td>";
			}
		}
		
		var today = new Date();
		for(day=1; day<=lastDay; day++) {
			if((dayCnt % 7) == 0 || (dayCnt % 7) == 6) {
				className = "weekend";
			}else{
				className = "weekday";
			}
			if(today.getDate() == day && today.getMonth() == date.getMonth() && today.getFullYear() == date.getFullYear()) {
				className += " today"
			}
			html += "<td class='valid-day "+className+" clickable' onclick='wcCalendar.setDate("+date.getFullYear()+", "+(date.getMonth()+1)+", "+day+", \""+fieldId+"\"); wcCalendar.hideCalendar();'>"+day+"</td>";
			
			dayCnt++;
			if(dayCnt % 7 == 0) {
				html += "</tr>";
				html += "<tr>";
			}
		}
		var remDays = dayCnt % 7; 
		if(remDays) {
			for(dayCnt=remDays; dayCnt<7; dayCnt++) {
				html += "<td class='empty'>&nbsp;</td>";
			}
		}
		
		html += "<tr class='wc-cal-footer'>"+
		"<td colspan=3 class='border clickable' title='Clear Date Field' onclick='wcCalendar.clearDate(\""+fieldId+"\");'>Clear</td>"+
		"<td></td>"+
		"<td colspan=3 class='border clickable' title='Close Calendar' onclick='wcCalendar.hideCalendar();'>Close</td>"+
		"</tr>";
		html += "</table>";
		
		
		document.getElementById("wc-calendar").innerHTML = html;
	},
	
	moveToDate:	function(month, year, fieldId) {
		if(month < 0) {
			month = 11;
			year--;
		}else if(month > 11) {
			month = 0;
			year++;
		}
		newDate = new Date();
		newDate.setFullYear(year, month, 1);
		wcCalendar.drawCalendar(fieldId, newDate);
	},
	
	setDate: function(year, month, day, fieldId) {
		document.getElementById(fieldId).value = year+"-"+wcCalendar.numFormat(month, 2, "0", "left")+"-"+wcCalendar.numFormat(day, 2, "0", "left");
	},
	
	clearDate: function(fieldId) {
		document.getElementById(fieldId).value = "";
	},
	
	numFormat: function(str, len, character, side) {
		if(!side) {
			side = "left";
		}
		str = str.toString();
		if(str.length < len) {
			while(str.length < len) {
				if(side == "left") {
					str = character+str;
				}else if(side == "right"){
					str = str+character;
				}
			}
		}
		
		return str;
	},
	
	//month 0-11
	getLastDay: function(month,year) {
		var m = [31,28,31,30,31,30,31,31,30,31,30,31];
		if (month != 1) return m[month]; //Feb, leap years, grrr
		if (year%4 != 0) return m[1];
		if (year%100 == 0 && year%400 != 0) return m[1];
		return m[1] + 1;
	},
	
	getXOffset:	function(p_elm) {
		var elm;
    if(typeof(p_elm) == "object"){
      elm = p_elm;
    } else {
      elm = document.getElementById(p_elm);
    }
		var xOff = 0;
		while (elm != null) {
			xOff += elm.offsetLeft;
			elm = elm.offsetParent;
		}
		return parseInt(xOff);
	},
	
	getYOffset: function(p_elm) {
		var elm;
    if(typeof(p_elm) == "object"){
      elm = p_elm;
    } else {
      elm = document.getElementById(p_elm);
    }
		var yOff = elm.offsetHeight;
		
		while (elm != null) {
			yOff += elm.offsetTop;
			elm = elm.offsetParent;
		}
		return parseInt(yOff);
	}
};