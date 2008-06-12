// (c) David Grudl aka -dgx-
//
// more info: http://www.dgx.cz/knowhow/eolas-workaround/


var objects = document.getElementsByTagName("object");

for (var i=0; i<objects.length; i++)
    objects[i].outerHTML = objects[i].outerHTML;