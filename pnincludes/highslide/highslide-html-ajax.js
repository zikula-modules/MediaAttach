/******************************************************************************
Name:    Highslide HTML Extension
Version: 1.0.2
Author:  Torstein Hønsi
Support: http://vikjavev.no/highslide/forum
Email:   See http://vikjavev.no/megsjol

Licence:
Highslide JS is licensed under a Creative Commons Attribution-NonCommercial 2.5
License (http://creativecommons.org/licenses/by-nc/2.5/).

You are free:
	* to copy, distribute, display, and perform the work
	* to make derivative works

Under the following conditions:
	* Attribution. You must attribute the work in the manner  specified by  the
	  author or licensor.
	* Noncommercial. You may not use this work for commercial purposes.

* For  any  reuse  or  distribution, you  must make clear to others the license
  terms of this work.
* Any  of  these  conditions  can  be  waived  if  you  get permission from the 
  copyright holder.

Your fair use and other rights are in no way affected by the above.
******************************************************************************/

// These properties can be overridden in the function call for each expander:
hs.push(hs.overrides, 'contentId');
hs.push(hs.overrides, 'allowWidthReduction');
hs.push(hs.overrides, 'allowHeightReduction');
hs.push(hs.overrides, 'objectType');
hs.push(hs.overrides, 'objectWidth');
hs.push(hs.overrides, 'objectHeight');
hs.push(hs.overrides, 'objectLoadTime');
hs.push(hs.overrides, 'swfObject');

hs.allowWidthReduction = false;
hs.allowHeightReduction = true;
hs.objectLoadTime = 'before';

hs.htmlExpand = function(a, params) {
	if (!hs.$(params.contentId)) return true;
	try {
		hs.hasHtmlExpanders = true;
    	new HsExpander(a, params, 'html');
		return false;
	} catch (e) {
		return true; // script failed: try firing default href
	}	
};

hs.identifyContainer = function (parent, className) {
	for (i = 0; i < parent.childNodes.length; i++) {
    	if (parent.childNodes[i].className == className) {
			return parent.childNodes[i];
		}
	}
};

HsExpander.prototype.htmlCreate = function () {
	this.origContent = hs.$(this.contentId);
	this.origContent.style.position = 'relative';
    
    var div = hs.createElement('div', null,
		{
			padding: '0 '+ hs.marginRight +'px 0 '+ hs.marginLeft +'px',
			position: 'absolute',
			left: 0,
			top: 0
		},
		document.body
	);
	this.origContent.style.visibility = 'hidden';
	this.origContent.className += ' highslide-display-block';
	
	this.innerContent = this.origContent.cloneNode(true);
	this.innerContent.id = null;
	
    hs.setStyles(this.innerContent, { border: 'none', width: 'auto', height: 'auto' });
    
	this.setObjContainerSize(this.origContent);
	this.setObjContainerSize(this.innerContent, 1);
	div.appendChild(this.origContent); // to get full width
	
    this.content = hs.createElement(
    	'div',
    	{	className: 'highslide-html' },
		{
			position: 'relative',
			zIndex: 3,
			overflow: 'hidden',
			width: this.thumbWidth +'px',
			height: this.thumbHeight +'px'
		}
	);
    this.content.appendChild(this.innerContent);
    if (this.objectType == 'ajax') this.getAjaxContent();
    else this.onLoad();
};
    
HsExpander.prototype.htmlGetSize = function() {
	this.newWidth = this.origContent.offsetWidth;
    this.newHeight = this.origContent.offsetHeight;
    if (hs.ie && this.newHeight > parseInt(this.origContent.currentStyle.height)) { // ie css bug
		this.newHeight = parseInt(this.origContent.currentStyle.height);
	}
	// hide origContent
	this.origContent.className = this.origContent.className.replace(' highslide-display-block', '');	
	//this.onLoad();
};

HsExpander.prototype.setObjContainerSize = function(parent, auto) {
	if (this.swfObject || this.objectType == 'iframe') {
		var c = hs.identifyContainer(parent, 'highslide-body');
		if (auto) {
			c.style.width = 'auto';
			c.style.height = 'auto';		
		} else {
			c.style.width = this.swfObject ? this.swfObject.attributes.width +'px' : this.objectWidth +'px';
			c.style.height = this.swfObject ? this.swfObject.attributes.height +'px' : this.objectHeight +'px';
		}
	}
	
};
HsExpander.prototype.writeExtendedContent = function () {
	this.objContainer = hs.identifyContainer(this.innerContent, 'highslide-body');
	if (this.objectType == 'iframe') {
		
		var key = this.key;
		this.iframe = hs.createElement('iframe',
			{
				frameBorder: 0,
				src: hs.getSrc(this.a)
			},
			{
				width: this.objectWidth +'px',
				height: this.objectHeight +'px'
			},
			this.objContainer
		);
		
		if (this.objectLoadTime == 'after') this.correctIframeSize();
		
	} else if (this.swfObject) {	
		this.objContainer.id = this.objContainer.id || 'hs-flash-id-' + this.key;
		this.swfObject.write(this.objContainer.id);	
	} 
};

HsExpander.prototype.correctIframeSize = function () {
	var wDiff = this.innerContent.offsetWidth - this.objContainer.offsetWidth;
    if (wDiff < 0) wDiff = 0;
	var hDiff = this.innerContent.offsetHeight - this.objContainer.offsetHeight;
    
    hs.setStyles(this.iframe, { width: (this.x.span - wDiff) +'px', height: (this.y.span - hDiff) +'px' });
    hs.setStyles(this.objContainer, { width: this.iframe.style.width, height: this.iframe.style.height });
    
    this.scrollingContent = this.iframe;
    this.scrollerDiv = 'scrollingContent';
};

HsExpander.prototype.htmlSizeOperations = function () {
	this.setObjContainerSize(this.innerContent);
	
	if (this.objectLoadTime == 'before') this.writeExtendedContent();		

	// store for resize
    this.finalLeft = this.x.min;
    this.finalTop = this.y.min;    	
    
    // handle minimum size   
    if (this.x.span < this.newWidth && !this.allowWidthReduction) this.x.span = this.newWidth;
    if (this.y.span < this.newHeight && !this.allowHeightReduction) this.y.span = this.newHeight;
    this.scrollerDiv = 'innerContent';
    
    this.mediumContent = hs.createElement('div', null, 
    	{ 
    		width: this.x.span +'px',
    		position: 'relative',
    		left: (this.finalLeft - this.thumbLeft) +'px',
    		top: (this.finalTop - this.thumbTop) +'px'
    	}, this.content);
	
    this.mediumContent.appendChild(this.innerContent);
    
    var node = hs.identifyContainer(this.innerContent, 'highslide-body');
    if (node && !this.swfObject && this.objectType != 'iframe') {    	
		var cNode = node.cloneNode(true); // to get true width
    	
    	node.innerHTML = '';
    	
    	hs.setStyles ( node, 
    		{
    			margin: 0,
    			border: 'none',
    			padding: 0,
    			overflow: 'hidden'
			}
    	);
    	node.appendChild(cNode);
    	var wDiff = this.innerContent.offsetWidth - node.offsetWidth;
    	var hDiff = this.innerContent.offsetHeight - node.offsetHeight;
    	
    	var kdeBugCorr = hs.safari || navigator.vendor == 'KDE' ? 1 : 0; // KDE repainting bug
    	node.style.width = (this.x.span - wDiff - kdeBugCorr) +'px';
    	node.style.height = (this.y.span - hDiff) +'px';
    	if (cNode.offsetHeight > node.offsetHeight)	{
    		node.style.overflow = 'auto';
    		if (kdeBugCorr) node.style.width = (parseInt(node.style.width) + kdeBugCorr) + 'px';
		}
    	this.scrollingContent = node;
    	this.scrollerDiv = 'scrollingContent';
	} 
	
    if (this.iframe && this.objectLoadTime == 'before') this.correctIframeSize();
    if (!this.scrollingContent && this.y.span < this.mediumContent.offsetHeight) this.scrollerDiv = 'content';
	
	if (this.scrollerDiv == 'content' && !this.allowWidthReduction && this.objectType != 'iframe') {
		this.x.span += 17; // room for scrollbars
	}
	if (this.scrollerDiv && this[this.scrollerDiv].offsetHeight > this[this.scrollerDiv].parentNode.offsetHeight) {
		setTimeout("hs.expanders["+ this.key +"]."+ this.scrollerDiv +".style.overflow = 'auto'",
			 hs.expandDuration);
	}
};

HsExpander.prototype.htmlSetSize = function (w, h, x, y, offset, end) {
	try {
		hs.setStyles(this.content, { width: w +'px', height: h +'px' });
		hs.setStyles(this.wrapper, { visibility: 'visible', left: x +'px', top: y +'px'});
		hs.setStyles(this.mediumContent, { left: (this.finalLeft - x) +'px', top: (this.finalTop - y) +'px' });
		
		this.innerContent.style.visibility = 'visible';
		
		if (this.objOutline && this.outlineWhileAnimating) {
			var o = this.objOutline.offset - offset;
			this.positionOutline(x + o, y + o, w - 2*o, h - 2*o, 1);
		}
		
		if (end == 1) setTimeout('hs.expanders['+this.key+'].onExpanded()', 0); // jerk in IE
		else if (end == -1) setTimeout('hs.expanders['+this.key+'].onEndClose()', 0);
		
	} catch (e) {
		window.location.href = hs.expanders[key].a.href;
	}
};

HsExpander.prototype.htmlOnClose = function() {
	if (this.objectLoadTime == 'after') this.destroyObject();		
	if (this.scrollerDiv && this.scrollerDiv != 'scrollingContent') 
		this[this.scrollerDiv].style.overflow = 'hidden';
	if (this.swfObject) hs.$(this.swfObject.getAttribute('id')).StopPlay();
};

HsExpander.prototype.destroyObject = function () {
	this.objContainer.innerHTML = '';
};


HsExpander.prototype.getAjaxContent = function () {
	var xmlHttp, id;
	var exp = hs.expanders[this.key];
	try { xmlHttp = new XMLHttpRequest(); }
	catch (e) {
		try { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) {
			try { xmlHttp  =new ActiveXObject("Microsoft.XMLHTTP"); }
			catch (e) { location.href = hs.getSrc(exp.a); }
		}
	}
	var src = hs.getSrc(this.a);
	if (src.match('#')) {
		var arr = src.split('#');
		src = arr[0];
		id = arr[1];
	}
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4) {
			var s = exp.getAjaxInnerHTML(xmlHttp.responseText, id);
			exp.objContainer = hs.identifyContainer(exp.innerContent, 'highslide-body');
			exp.objContainer.innerHTML = s;
    
			exp.objOrigContainer = hs.identifyContainer(exp.origContent, 'highslide-body');
			exp.objOrigContainer.innerHTML = s;
			
			exp.onLoad();
		}
	}
	
	xmlHttp.open("GET", src, true);
	xmlHttp.send(null);
};

HsExpander.prototype.getAjaxInnerHTML = function(s, id) {
	if (id) {
		var dom = this.parseXML(s);
		var el = hs.checkNodeId(dom.documentElement, id);
		if (el && hs.ie) return el.xml;
		else if (el) return el.innerHTML;
	} 
	return s.replace(/\s/g, ' ').replace(/.*?<body.*?>(.*?)<\/body>.*?/, '$1');

};

hs.checkNodeId = function (node, id) {
	var type = hs.ie ? 'unknown' : 'function';
	if (typeof node.getAttribute == type && node.getAttribute('id') == id) return node;
	
	else if (node.childNodes) {
		var hit;
		for (var i = 0; i < node.childNodes.length; i++) {
			hit = hs.checkNodeId(node.childNodes[i], id);
			if (hit) return hit;
		}
	}
	return false;
};

HsExpander.prototype.parseXML = function (xml) {
	var dom = null;
	if (window.DOMParser) {
		try { dom = (new DOMParser()).parseFromString(xml, "text/xml"); } 
		catch (e) { dom = null; }
	} else if (window.ActiveXObject) {
		try {
			dom = new ActiveXObject('Microsoft.XMLDOM');
			dom.async = false;
			if (!dom.loadXML(xml)) location.href = hs.getSrc(this.a);
		} catch (e) { dom = null; }
   } else location.href = hs.getSrc(this.a);
   return dom;
};



