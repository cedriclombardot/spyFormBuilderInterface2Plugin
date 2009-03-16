/*
SimpleAjax for SimpleJS ver 0.1 beta
------------------------------------
SimpleJS is developed by Christophe "Dyo" Lefevre (http://bleebot.com/)
$ajax function is based on Simple AJAX Code-Kit (SACK)
Gregory Wild-Smith (http://www.twilightuniverse.com/)
*/
var enableCache=true;
var jsCache=new Array();
var DynObj=new Array();
function $ajax(_1){
this.xmlhttp=null;
this.resetData=function(){
this.method="POST";
this.queryStringSeparator="?";
this.argumentSeparator="&";
this.URLString="";
this.encodeURIString=true;
this.execute=false;
this.element=null;
this.elementObj=null;
this.requestFile=_1;
this.vars=new Object();
this.responseStatus=new Array(2);
};
this.resetFunctions=function(){
this.onLoading=function(){
};
this.onLoaded=function(){
};
this.onInteractive=function(){
};
this.onCompletion=function(){
};
this.onError=function(){
};
this.onFail=function(){
};
};
this.reset=function(){
this.resetFunctions();
this.resetData();
};
this.crAjx=function(){
try{
this.xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e1){
try{
this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e2){
this.xmlhttp=null;
}
}
if(!this.xmlhttp){
if(typeof XMLHttpRequest!="undefined"){
this.xmlhttp=new XMLHttpRequest();
}else{
this.failed=true;
}
}
};
this.setVar=function(_2,_3){
this.vars[_2]=Array(_3,false);
};
this.encVar=function(_4,_5,_6){
if(true==_6){
return Array(encodeURIComponent(_4),encodeURIComponent(_5));
}else{
this.vars[encodeURIComponent(_4)]=Array(encodeURIComponent(_5),true);
}
};
this.processURLString=function(_7,_8){
encoded=encodeURIComponent(this.argumentSeparator);
regexp=new RegExp(this.argumentSeparator+"|"+encoded);
varArray=_7.split(regexp);
for(i=0;i<varArray.length;i++){
urlVars=varArray[i].split("=");
if(true==_8){
this.encVar(urlVars[0],urlVars[1]);
}else{
this.setVar(urlVars[0],urlVars[1]);
}
}
};
this.createURLString=function(_9){
if(this.encodeURIString&&this.URLString.length){
this.processURLString(this.URLString,true);
}
if(_9){
if(this.URLString.length){
this.URLString+=this.argumentSeparator+_9;
}else{
this.URLString=_9;
}
}
this.setVar("rndval",new Date().getTime());
urlstringtemp=new Array();
for(key in this.vars){
if(false==this.vars[key][1]&&true==this.encodeURIString){
encoded=this.encVar(key,this.vars[key][0],true);
delete this.vars[key];
this.vars[encoded[0]]=Array(encoded[1],true);
key=encoded[0];
}
urlstringtemp[urlstringtemp.length]=key+"="+this.vars[key][0];
}
if(_9){
this.URLString+=this.argumentSeparator+urlstringtemp.join(this.argumentSeparator);
}else{
this.URLString+=urlstringtemp.join(this.argumentSeparator);
}
};
this.runResponse=function(){
eval(this.response);
};
this.runAJAX=function(_a){
if(this.failed){
this.onFail();
}else{
this.createURLString(_a);
if(this.element){
this.elementObj=$(this.element);
}
if(this.xmlhttp){
var _b=this;
if(this.method=="GET"){
totalurlstring=this.requestFile+this.queryStringSeparator+this.URLString;
this.xmlhttp.open(this.method,totalurlstring,true);
}else{
this.xmlhttp.open(this.method,this.requestFile,true);
try{
this.xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
}
catch(e){
}
}
this.xmlhttp.onreadystatechange=function(){
switch(_b.xmlhttp.readyState){
case 1:
_b.onLoading();
break;
case 2:
_b.onLoaded();
break;
case 3:
_b.onInteractive();
break;
case 4:
_b.response=_b.xmlhttp.responseText;
_b.responseXML=_b.xmlhttp.responseXML;
_b.responseStatus[0]=_b.xmlhttp.status;
_b.responseStatus[1]=_b.xmlhttp.statusText;
if(_b.execute){
_b.runResponse();
}
if(_b.elementObj){
elemNodeName=_b.elementObj.nodeName;
elemNodeName.toLowerCase();
if(elemNodeName=="input"||elemNodeName=="select"||elemNodeName=="option"||elemNodeName=="textarea"){
_b.elementObj.value=_b.response;
}else{
_b.elementObj.innerHTML=_b.response;
}
}
if(_b.responseStatus[0]=="200"){
_b.onCompletion();
}else{
_b.onError();
}
_b.URLString="";
break;
}
};
this.xmlhttp.send(this.URLString);
}
}
};
this.reset();
this.crAjx();
}
function ajax_installScript(_c){
if(!_c){
return;
}
if(window.execScript){
window.execScript(_c);
}else{
if(window.jQuery&&jQuery.browser.safari){
STO(_c,0);
}else{
STO(_c,0);
}
}
}
function $ajax_show(_d,_e,_f,_10,_11){
if(_11=="appear"){
$opacity(_d,0,101,600);
}
if(_11=="highlight"){
$highlight(_d);
}
var _12=$(_d);
_12.innerHTML=DynObj[_e].response;
if(_11=="blind"){
$(_d).style.position="";
$blinddown(_d);
}
if(enableCache){
jsCache[_f]=DynObj[_e].response;
}
DynObj[_e]=false;
ajax_parseJs(_12);
}
function $ajaxreplace(_13,url){
$opacity(_13,100,0,400);
$(_13).style.height="";
scr="$ajaxload('"+_13+"','"+url+"',false,'appear',false)";
STO(scr,400);
}
function $ajaxload(_15,url,_17,_18,_19){
if(_18=="appear"){
changeOpac(0,_15);
}
if(_18=="blind"){
var ids=$(_15).style;
ids.overflow="hidden";
ids.display="block";
ids.height="0px";
}
if(_19){
if(enableCache&&jsCache[url]){
if(_18=="appear"){
$opacity(_15,0,101,600);
}
if(_18=="highlight"){
$highlight(_15);
}
$(_15).innerHTML=jsCache[url];
if(_18=="blind"){
$(_15).style.position="";
$blinddown(_15);
}
return;
}
}
var _1b=DynObj.length;
if(_17!=false){
$(_15).innerHTML=_17;
}
DynObj[_1b]=new $ajax();
DynObj[_1b].requestFile=url;
DynObj[_1b].onCompletion=function(){
$ajax_show(_15,_1b,url,_17,_18);
};
DynObj[_1b].runAJAX();
}
function ajax_parseJs(obj){
var _1d=obj.getElementsByTagName("SCRIPT");
var _1e="";
var _1f="";
for(var no=0;no<_1d.length;no++){
if(_1d[no].src){
var _21=document.getElementsByTagName("head")[0];
var _22=document.createElement("script");
_22.setAttribute("type","text/javascript");
_22.setAttribute("src",_1d[no].src);
}else{
if(DHTMLSuite.clientInfoObj.isOpera){
_1f=_1f+_1d[no].text+"\n";
}else{
_1f=_1f+_1d[no].innerHTML;
}
}
}
if(_1f){
ajax_installScript(_1f);
}
}