/*
Acco (Accordion) for SimpleJS
------------------------------
Acco is developed by Christophe "Dyo" Lefevre (http://bleebot.com/)
*/
var AccoCache = new Array();
function $AccoInit(str) {
   accomax = str.match(/[;]/g).length;
   for (var i = 0; i < accomax; i++) {
      pos = str.indexOf(";");
      AccoCache.push(str.substring(0, pos));
      str = str.substring(pos + 1, str.length);
      }
   }
function $accopush(accobjnum, elastic) {
   for (var i = 0; i < AccoCache.length; i++) {
      if (i != accobjnum) {
         $blindup(AccoCache[i], 200);
         }
      else {
         if (elastic == true) STO("$blinddown('" + AccoCache[i] + "', 200)", 400);
         else $blinddown(AccoCache[i], 200);
         }
      }
   }