var script = document.querySelector(".celtra-iframe-script"),
	iframe = document.createElement("iframe");
iframe.width = 320;
iframe.height = 50;
iframe.setAttribute("frameborder", '0');
iframe.setAttribute("scrolling", 'no');
script.parentNode.appendChild(iframe);

iframe.contentDocument.open();
iframe.contentDocument.close();
iframe.contentDocument.body.style.margin = 0;

//iframe.contentWindow.script = script;
iframe.contentWindow.loadStartTimestamp = window.loadStartTimestamp;

var sc = iframe.contentDocument.createElement('script');
sc.className = "celtra-iframe-script";
sc.textContent = "var img = document.createElement('img')," + 
	"tag = document.querySelector('.celtra-iframe-script');" +
	"img.onload = function() {" + 
	    "/* track load time on static image 'onload' event */" + 
	    "var loadTime = new Date/1000 - window.loadStartTimestamp;" + 
	    "(new Image()).src = 'http://gorankaran.s3-external-1.amazonaws.com/1px.gif?type=iframe-static-image&loadTime=' + loadTime + '&' + Math.random();" + 
	"};" + 
	"img.onclick = function() {" + 
	    "var r = document.createElement('script');" + 
	    "r.id = 'celtra-script-' + (window.celtraScriptIndex = (window.celtraScriptIndex||0)+1);" + 
	    "r.src = 'http://ads.celtra.com/e217a55d/web.js?placementId=33dfd692&scriptId=' + r.id + '&clientTimestamp=' + (new Date/1000);" + 
	    "img.parentNode.insertBefore(r, img.nextSibling);" + 
	"}.bind(img);" + 
	"img.src = 'http://gorankaran.s3-external-1.amazonaws.com/static.jpg';" + 
	"tag.parentNode.appendChild(img);"
	;
iframe.contentDocument.body.appendChild(sc);
