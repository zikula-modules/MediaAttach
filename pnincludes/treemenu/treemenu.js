/*
 +-------------------------------------------------------------------+
 |                   J S - T R E E M E N U   (v2.1)                  |
 |                                                                   |
 | Copyright Gerd Tentler               www.gerd-tentler.de/tools    |
 | Created: Apr. 9, 2003                Last modified: Jan. 10, 2007 |
 +-------------------------------------------------------------------+
 | This program may be used and hosted free of charge by anyone for  |
 | personal purpose as long as this copyright notice remains intact. |
 |                                                                   |
 | Obtain permission before selling the code for this program or     |
 | hosting this software on a commercial website or redistributing   |
 | this software over the Internet or in any other medium. In all    |
 | cases copyright must remain intact.                               |
 +-------------------------------------------------------------------+

======================================================================================================
 This script was tested with the following systems and browsers:

 - Windows XP: IE 6, NN 7, Opera 7 + 9, Firefox 2
 - Mac OS X:   IE 5, Safari 1

 If you use another browser or system, this script may not work for you - sorry.
======================================================================================================
*/

var mObj = new Array();

function TREEMENU(openAll) {
//----------------------------------------------------------------------------------------------------
// Configuration
//----------------------------------------------------------------------------------------------------

  this.width = 150;                                 // menu width (pixels)
  this.bgColor = "#F0F8FF";                         // menu background color
  this.autoClose = false;                           // close level-one-nodes automatically (true or false)
  this.floating = false;                            // floating menu (true or false)*

  this.title = "";                                  // menu title
  this.titleFont = "Arial, Helvetica";              // title font family (CSS spec.)
  this.titleSize = 12;                              // title font size (pixels)
  this.titleBold = true;                            // title bold font (true or false)
  this.titleColor = "#000099";                      // title font color
  this.titleBGColor = "#E0F0FF";                    // title background color

  this.itemMargin = 1;                              // item margin (pixels)
  this.itemPadding = 2;                             // item padding (pixels)
  this.itemColor = "#000099";                       // item font color
  this.itemBGColor = "#E0F0FF";                     // item background color
  this.itemBGColor1 = "#E0F0FF";                    // item background color for level-one-items
  this.itemFont = "Verdana, Arial, Helvetica";      // item font family (CSS spec.)
  this.itemSize = 10;                               // item font size (pixels)
  this.itemBold = false;                            // item bold font (true or false)
  this.itemWrap = false;                            // item word wrap (true or false)
  this.itemActive = "red";                          // active item font color
  this.itemActiveUnderline = true;                  // active item underline (true or false)
  this.itemOnClick = "open";                        // action when item is clicked ("open" or "close" node)

  this.iconWidth = 12;                              // icon width (pixels)
  this.iconHeight = 10;                             // icon height (pixels)
  this.iconClosed = "closed.gif";                   // icon closed (path)
  this.iconClosedHilight = "closed_hilight.gif";    // icon closed hilight (path)
  this.iconOpen = "open.gif";                       // icon open (path)
  this.iconOpenHilight = "open_hilight.gif";        // icon open hilight (path)
  this.iconPoint = "point.gif";                     // icon point (path)
  this.iconPointHilight = "point_hilight.gif";      // icon point hilight (path)

  this.imgBlank = "blank.gif";                      // blank image (path)

// * With Safari 1 (Mac OS X) performance was poor, i.e. floating speed was slow. With IE 5 (Mac OS X)
//   floating didn't work properly.

//----------------------------------------------------------------------------------------------------
// Functions
//----------------------------------------------------------------------------------------------------

  this.mNr = 0;
  this.curItem = -1;
  this.hilightItem = -1;
  this.targetWindow = 0;
  this.iv = 0;
  this.items = new Array();

  if(openAll == null) openAll = false;
  this.openAll = openAll;

  this.entry = function(level, text, url, target, onClick) {
    var i = this.items.length;
    this.items[i] = new makeItem(level, text, url, target, onClick);
  }

  this.getObj = function(id) {
    var obj;
    if(document.getElementById) obj = document.getElementById(id);
    else if(document.all) obj = document.all[id];
    return obj;
  }

  this.getScrTop = function() {
    var scrTop = 0;
    if(document.documentElement && document.documentElement.scrollTop)
      scrTop = document.documentElement.scrollTop;
    else if(document.body && document.body.scrollTop)
      scrTop = document.body.scrollTop;
    else if(window.pageYOffset) scrTop = window.pageYOffset;
    return scrTop;
  }

  this.setHilight = function(item) {
    if(this.hilightItem >= 0) {
      var i = this.hilightItem;
      if(this.items[i].icon == this.iconOpenHilight) this.items[i].icon = this.iconOpen;
      else if(this.items[i].icon == this.iconClosedHilight) this.items[i].icon = this.iconClosed;
      else if(this.items[i].icon == this.iconPointHilight) this.items[i].icon = this.iconPoint;
    }
    this.hilightItem = item;
    if(this.items[item].icon == this.iconOpen) this.items[item].icon = this.iconOpenHilight;
    else if(this.items[item].icon == this.iconClosed) this.items[item].icon = this.iconClosedHilight;
    else if(this.items[item].icon == this.iconPoint) this.items[item].icon = this.iconPointHilight;
  }

  this.openNode = function(item, rebuild) {
    if(this.items[item].node) {
      this.curItem = item;
      this.items[item].icon = (item == this.hilightItem) ? this.iconOpenHilight : this.iconOpen;
    }
    if(rebuild) this.newMenu();
  }

  this.closeNode = function(item, rebuild) {
    this.curItem = -1;
    if(this.items[item].node) {
      this.items[item].icon = (item == this.hilightItem) ? this.iconClosedHilight : this.iconClosed;
    }
    if(rebuild) this.newMenu();
  }

  this.viewNode = function(item) {
    var icon = this.items[item].icon;
    if(icon == this.iconOpen || icon == this.iconOpenHilight) this.closeNode(item, true);
    else this.openNode(item, true);
  }

  this.jump = function(item) {
    this.setHilight(item);
    if(this.itemOnClick.toLowerCase() == 'close') this.closeNode(item, true);
    else this.openNode(item, true);
    if(this.items[item].onClick) eval(this.items[item].onClick);
    if(this.items[item].url) {
      if(this.items[item].target) {
        if(this.items[item].target.indexOf('parent.') == -1 && this.items[item].target.indexOf('top.') == -1) {
          if(this.targetWindow && !this.targetWindow.closed) this.targetWindow.location.href = this.items[item].url;
          else this.targetWindow = window.open(this.items[item].url, 'targetWindow');
          this.targetWindow.focus();
        }
        else eval(this.items[item].target + '.location.href = "' + this.items[item].url + '"');
      }
      else document.location.href = this.items[item].url;
    }
  }

  this.floatIt = function() {
    var obj = this.getObj('divTreeMenu' + this.mNr);
    var scrTop = this.getScrTop();
    var elmTop = (obj.style.top != '') ? parseInt(obj.style.top) : 0;
    if(elmTop != scrTop) this.smoothIt(obj, elmTop, scrTop);
  }

  this.smoothIt = function(obj, elmTop, scrTop) {
    if(scrTop != elmTop) {
      var percent = .1 * (scrTop - elmTop);
      if(percent > 0) percent = Math.ceil(percent);
      else percent = Math.floor(percent);
      elmTop += percent;
      obj.style.top = elmTop + 'px';
    }
  }

  this.content = function(item) {
    var text = '';
    var bgc = (this.items[item].level <= 1) ? this.itemBGColor1 : this.itemBGColor;
    text += '<table border=0 cellspacing=' + this.itemMargin + ' cellpadding=0 width=100%><tr>' +
            '<td' + (bgc ? ' bgcolor=' + bgc  : '') + '>' +
            '<table border=0 cellspacing=0 cellpadding=' + this.itemPadding + '><tr valign=top>';
    if(this.items[item].level > 1) {
      for(i = 1; i < this.items[item].level; i++) {
        text += '<td><img' +
                ' src="' + this.imgBlank + '"' +
                ' width=' + this.iconWidth +
                ' height=' + this.iconHeight +
                '></td>';
      }
    }
    text += '<td>';
    if(this.items[item].node) text += '<a href="javascript:mObj[' + this.mNr + '].viewNode(' + item + ')">';
    text += '<img src="' + this.items[item].icon + '" border=0' +
            ' width=' + this.iconWidth +
            ' height=' + this.iconHeight +
            '></a></td>' +
            '<td' + (this.itemWrap ? '>' : ' nowrap>') +
            '<a href="javascript:mObj[' + this.mNr + '].jump(' + item + ')" class="' +
            ((item == this.hilightItem) ? 'cssLinkHilight' : 'cssLink') + this.mNr + '">' +
            (this.itemBold ? '<b>' + this.items[item].text + '</b>' : this.items[item].text) +
            '</a></td></tr></table></td></tr></table>';
    return text;
  }

  this.newMenu = function() {
    var menu = '';
    var i, j;
    var obj = this.getObj('divTreeMenu' + this.mNr);
    if(obj) {
      if(this.autoClose && this.curItem >= 0) {
        if(this.items[this.curItem].level <= 1) {
          for(i = 0; i < this.items.length; i++) {
            if(i != this.curItem && this.items[i].node && this.items[i].level == 1) {
              this.items[i].icon = this.iconClosed;
            }
          }
        }
      }
      if(this.title) menu += '<div class="cssTitle">' + this.title + '</div>';
      for(i = 0; i < this.items.length; i++) {
        menu += this.content(i);
        if(this.items[i].icon == this.iconClosed || this.items[i].icon == this.iconClosedHilight) {
          for(j = i+1; j < this.items.length && this.items[j].level > this.items[i].level; j++);
          i = j - 1;
        }
      }
      obj.innerHTML = menu;
    }
  }

  this.buildContainer = function() {
    var lnk1 = '.cssLink' + this.mNr;
    var lnk2 = '.cssLinkHilight' + this.mNr;
    document.write('<style> .cssMenu' + this.mNr + ' { ' +
                   'position: relative; ' +
                   'width: ' + this.width + 'px; ' +
                   (this.floating ? 'z-index: 69; ' : '') +
                   (this.bgColor ? 'background-color: ' + this.bgColor + '; ' : '') +
                   '} ' + lnk1 + ', ' + lnk1 + ':visited, ' + lnk1 + ':active { ' +
                   'color: ' + this.itemColor + '; ' +
                   'font-family: ' + this.itemFont + '; ' +
                   'font-size: ' + this.itemSize + 'px; ' +
                   'text-decoration: none; ' +
                   '} .cssTitle { ' +
                   'color: ' + this.titleColor + '; ' +
                   (this.titleBGColor ? 'background-color: ' + this.titleBGColor + '; ' : '') +
                   'font-family: ' + this.titleFont + '; ' +
                   'font-size: ' + this.titleSize + 'px; ' +
                   (this.titleBold ? 'font-weight: bold; ' : '') +
                   '} ' + lnk1 + ':hover { ' +
                   'text-decoration: underline; ' +
                   '} ' + lnk2 + ', ' + lnk2 + ':visited, ' + lnk2 + ':active { ' +
                   'color: ' + this.itemActive + '; ' +
                   'font-family: ' + this.itemFont + '; ' +
                   'font-size: ' + this.itemSize + 'px; ' +
                   (this.itemActiveUnderline ? 'text-decoration: underline; ' : '') +
                   '} </style>' +
                   '<div id="divTreeMenu' + this.mNr + '" class="cssMenu' + this.mNr + '"></div>');
  }

  this.createStructure = function() {
    for(i = 0; i < this.items.length; i++) {
      if(!this.items[i].icon) {
        if(i < this.items.length-1 && this.items[i+1].level > this.items[i].level) {
          this.items[i].icon = this.openAll ? this.iconOpen : this.iconClosed;
          this.items[i].node = true;
        }
        else this.items[i].icon = this.iconPoint;
      }
    }
  }

  this.create = function() {
    this.mNr = mObj.length;
    if(mObj[this.mNr] = this) {
      this.buildContainer();
      this.createStructure();
      this.newMenu();
      if(this.floating) {
        if(this.iv) clearInterval(this.iv);
        this.iv = setInterval('mObj[' + this.mNr + '].floatIt()', 1);
      }
    }
    else alert("Could not create menu!");
  }

  this.open = function() {
    for(var i = 0; i < this.items.length; i++) {
      this.openNode(i, false);
    }
    this.newMenu();
  }

  this.close = function() {
    for(var i = 0; i < this.items.length; i++) {
      this.closeNode(i, false);
    }
    this.newMenu();
  }

  //------------------------------------------------------------------------
  // Arguments: position level 1, [position level 2], ... [position level n]
  // Example:   jumpTo(1, 3, 2, 1) ==> this jumps to menu item 1.3.2.1
  //
  this.jumpTo = function() {
    var pos, curPos, i;
    var item = 0;
    var level = 1;
    this.curItem = -1;
    if(arguments == null) arguments = this.jumpTo.arguments;
    for(i = 0; i < arguments.length; i++, level++) {
      pos = arguments[i];
      for(curPos = 0; item < this.items.length && curPos < pos; item++) {
        if(this.items[item].level == level) curPos++;
      }
      if(curPos == pos) {
        item -= 1;
        this.openNode(item, false);
      }
    }
    if(item) this.jump(item);
  }
  //------------------------------------------------------------------------
}

function makeItem(level, text, url, target, onClick) {
  this.level = level;
  this.text = text;
  this.url = url;
  this.target = target;
  this.onClick = onClick;
  this.icon = '';
  this.node = false;
}

//----------------------------------------------------------------------------------------------------
