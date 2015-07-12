function checkNumber(value) {
  var intRegex = /^(0|[1-9][0-9]*)$/;
  if (!intRegex.test(value)) {        
    return false;
  } else {
    return true;
  }
}

function numbersonly(e){
  var unicode=e.charCode? e.charCode : e.keyCode
  if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
  if (unicode<48||unicode>57) //if not a number
  return false //disable key press
  }
}

function trim(s)
{
	var l=0; var r=s.length -1;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	while(r > l && s[r] == ' ')
	{	r-=1;	}
	return s.substring(l, r+1);
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}
function formatangka(angka) {
   a = angka;
   b = a.replace(/[^\d]/g,"");
   c = "";
   panjang = b.length;
   j = 0;
   for (i = panjang; i > 0; i--) {
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)) {
       c = b.substr(i-1,1) + "," + c;
     } else {
       c = b.substr(i-1,1) + c;
     }
   }
   return c;
}

function getCurrentDate() {
  var time=new Date();
  var lmonth=time.getMonth()+1;
  var date=time.getDate();
  var year=time.getYear();
  if (year < 2000) year = year + 1900;
  return date + '-' + lmonth + '-' + year;
}

// check date
function checkdate(d,m,y)
{
  var yl=1990; // least year to consider
  var ym=2099; // most year to consider
  if (m<1 || m>12) return(false);
  if (d<1 || d>31) return(false);
  if (y<yl || y>ym) return(false);
  if (m==4 || m==6 || m==9 || m==11)
  if (d==31) return(false);
  if (m==2)
  {
    var b=parseInt(y/4);
    if (isNaN(b)) return(false);
    if (d>29) return(false);
    if (d==29 && ((y/4)!=parseInt(y/4))) return(false);
  }
  return(true);
}

function parse_date(string) {
    var date = new Date();
    var parts = String(string).split(/[- :]/);

    date.setFullYear(parts[0]);
    date.setMonth(parts[1] - 1);
    date.setDate(parts[2]);
    date.setHours(parts[3]);
    date.setMinutes(parts[4]);
    date.setSeconds(parts[5]);
    date.setMilliseconds(0);

    return date;
}

function format_mysql_date(str) {
    //2010-03-01
    var thn = str.substr(0,4);
    var bln = str.substr(5,2);
    var tgl = str.substr(8,2);
    return tgl + '-' + bln + '-' + thn;
}