
function getParameterByName(name){name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regex=new RegExp("[\\?&]"+name+"=([^&#]*)"),results=regex.exec(location.search);return results==null?"999999":decodeURIComponent(results[1].replace(/\+/g," "));}
var GATrafficSource=(function(){var pairs=(/(?:^|; )__utmz=([^;]*)/.exec(document.cookie)||[]).slice(1).pop().split('.').slice(4).join('.').split('|');var vals={};for(var i=0;i<pairs.length;i++){var temp=pairs[i].split('=');vals[temp[0]]=temp[1];}
return{'utm_source':(vals.utmgclid)?"google":vals.utmcsr,'utm_medium':(vals.utmgclid)?"cpc":vals.utmcmd,'utm_term':vals.utmctr,'utm_content':vals.utmcct,'utm_campaign':vals.utmccn,'utm_gclid':vals.utmgclid,'utm_utmip':vals.utmip};}());var obj=new Object();obj.LandingPage=document.URL;obj.Serial=getParameterByName("srl");obj.utm_source=GATrafficSource.utm_source;obj.utm_medium=GATrafficSource.utm_medium;obj.utm_term=GATrafficSource.utm_term;obj.utm_content=GATrafficSource.utm_content;obj.utm_campaign=GATrafficSource.utm_campaign;obj.utm_gclid=GATrafficSource.utm_gclid;obj.utm_utmip=GATrafficSource.utm_utmip;var jsonString=JSON.stringify(obj).replace(/[()]/g,"");function setTrackingCookie(c_name,value,minutes){var domain=".conduit.com";var exdate=new Date();exdate.setMinutes(exdate.getMinutes()+minutes);var c_value=escape(value)+((minutes==null)?"":"; expires="+exdate.toUTCString());document.cookie=c_name+"="+c_value+';domain=.conduit.com;path=/';}
function getCookie(c_name){var c_value=document.cookie;var c_start=c_value.indexOf(" "+c_name+"=");if(c_start==-1){c_start=c_value.indexOf(c_name+"=");}
if(c_start==-1){c_value=null;}
else{c_start=c_value.indexOf("=",c_start)+1;var c_end=c_value.indexOf(";",c_start);if(c_end==-1){c_end=c_value.length;}
c_value=unescape(c_value.substring(c_start,c_end));}
return c_value;}
function checkCookie(myCookieToCheck){var cookieName=getCookie(myCookieToCheck);if(cookieName!=null&&cookieName!=""){return true;}
else{return false;}}
window.onload=function(){if(!checkCookie('Marketing_Tracking_jason_Persistant')){setTrackingCookie("Marketing_Tracking_jason_Persistant",jsonString,60*10000);setTrackingCookie("Marketing_Tracking_jason_session",jsonString,60);}
if(ExcludeDomains()){setTrackingCookie("Marketing_Tracking_jason_session",jsonString,60);}};function ExcludeDomains(){var referrerdomain=document.referrer;if(referrerdomain.toLowerCase().indexOf('.conduit.')!=-1){return false;}
if(referrerdomain.toLowerCase().indexOf('.plimus.')!=-1){return false;}
if(referrerdomain.toLowerCase().indexOf('.bluesnap.')!=-1){return false;}
return true;}
