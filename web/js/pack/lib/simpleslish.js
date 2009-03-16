/*
Slish (SlideShow) for SimpleJS
------------------------------
Slish is developed by Christophe "Dyo" Lefevre (http://bleebot.com/)
*/
var SlishCache = new Array();
function $slish(id, str, time) {
   slishnum = 1;
   slishid = id;
   slishtime = time;
   slishdelay = false;
   slishmax = str.match(/[;]/g).length;
   for (var i = 0; i < slishmax; i++) {
        pos = str.indexOf(";");
        SlishCache.push(str.substring(0, pos));
        str = str.substring(pos + 1, str.length);
        }
   }
function $slishPLAY(time) {
	if (slishdelay == false) {
   	   slishdelay = time;
   	   $slishAUTO();
	   }
   }
function $slishSTOP() {
   slishdelay = false;
   }
function $slishAUTO() {
   if (slishdelay != false) {
   if (slishnum < slishmax) slishnum += 1;
   else slishnum = 1;
   num2 = slishnum - 1;
   id = slishid;
   $opacity(id, 100, 0, slishtime);
   STO("$opacity('" + id + "', 0, 100, " + slishtime + ")", slishtime);
   STO("$('" + id + "').src='" + SlishCache[num2] + "'", slishtime);
   STO("$slishAUTO()", slishdelay);
      }
   }
function $slishNEXT() {
   if (slishnum < slishmax)slishnum += 1;
   else slishnum = 1;
   $slishToNum(slishnum);
   }
function $slishPREV() {
   if (slishnum > 1)slishnum -= 1;
   else slishnum = slishmax;
   $slishToNum(slishnum);
   }
function $slishToNum(num) {
   slishdelay = false;
   slishnum = num;
   num2 = num - 1;
   id = slishid;
   $opacity(id, 100, 0, slishtime);
   STO("$opacity('" + id + "', 0, 100, " + slishtime + ")", slishtime);
   STO("$('" + id + "').src='" + SlishCache[num2] + "'", slishtime);
   }