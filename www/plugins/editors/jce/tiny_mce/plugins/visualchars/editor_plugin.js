(function(){tinymce.create('tinymce.plugins.VisualChars',{init:function(ed,url){var t=this;t.editor=ed;t.state=parseInt(tinymce.util.Cookie.get('jce_visualchars_state'));ed.onInit.add(function(){ed.dom.loadCSS(url+"/css/content.css");ed.controlManager.setActive('visualchars',t.state);t._toggleVisualChars(t.state);t._toggleVisualBlocks(ed.hasVisual&&t.state);if(ed.plugins.format){ed.plugins.format.onClearBlocks.add(function(){if(t.state){t._toggleVisualBlocks(ed.hasVisual&&t.state)}})}if(ed.plugins.paste){ed.plugins.paste.onPasteInsert.add(function(){if(t.state){t._toggleVisualBlocks(ed.hasVisual&&t.state)}})}});ed.addButton('visualchars',{title:'visualchars.desc',cmd:'mceVisualChars'});ed.addCommand('mceVisualChars',function(){ed.controlManager.setActive('visualchars',!t.state);t.state=!t.state;tinymce.util.Cookie.set('jce_visualchars_state',t.state?1:0);t._toggleVisualChars(t.state);t._toggleVisualBlocks(ed.hasVisual&&t.state)},t);ed.onExecCommand.add(function(ed,cmd,ui,val,o){if(t.state&&/(mceBlockQuote|FormatBlock)/.test(cmd)){t._toggleVisualBlocks(ed.hasVisual&&t.state)}if(cmd=='mceToggleVisualAid'){t._toggleVisualBlocks(ed.hasVisual&&t.state)}});ed.onKeyUp.add(function(ed,e){if(t.state){if(e.keyCode==13){t._toggleVisualBlocks(ed.hasVisual&&t.state);t._toggleVisualChars(t.state)}}});ed.onPreProcess.add(function(ed,o){if(o.get){t._toggleVisualChars(false,o.node);t._toggleVisualBlocks(false,o.node)}});ed.onSetContent.add(function(ed,o){t._toggleVisualChars(t.state);t._toggleVisualBlocks(ed.hasVisual&&t.state)})},getInfo:function(){return{longname:'Visual characters',author:'Moxiecode Systems AB / Ryan Demmer',authorurl:'http://tinymce.moxiecode.com',infourl:'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/visualchars',version:tinymce.majorVersion+"."+tinymce.minorVersion}},_toggleVisualBlocks:function(state,o){var t=this,ed=t.editor,b=o||ed.getBody();var blocks=ed.dom.select('p,div,h1,h2,h3,h4,h5,h6,blockquote,pre,address',b);if(state){ed.dom.addClass(blocks,'mceVisualAid')}else{ed.dom.removeClass(blocks,'mceVisualAid')}},_toggleVisualChars:function(state,o){var t=this,ed=t.editor,nl,i,h,d=ed.getDoc(),b=o||ed.getBody(),nv,s=ed.selection,bo;if(state){nl=[];tinymce.walk(b,function(n){if(n.nodeType==3&&n.nodeValue&&/(\u00a0|&nbsp;)/.test(n.nodeValue))nl.push(n)},'childNodes');for(i=0;i<nl.length;i++){nv=nl[i].nodeValue;nv=nv.replace(/(\u00a0|&nbsp;)/g,'<span class="mceItemHidden mceVisualNbsp">$1</span>');nv=nv.replace(/(\u00a0|&nbsp;)/g,'\u00b7');t._setOuterHTML(nl[i],nv,d)}}else{nl=tinymce.grep(ed.dom.select('span',b),function(n){return ed.dom.hasClass(n,'mceVisualNbsp')});for(i=0;i<nl.length;i++)t._setOuterHTML(nl[i],nl[i].innerHTML.replace(/(&middot;|\u00b7)/g,'&nbsp;'),d)}},_setOuterHTML:function(e,h,d){var t=this,ed=t.editor,dom=ed.dom;function setHTML(e,h,d){var n,tp;tp=d.createElement("body");tp.innerHTML=h;n=tp.lastChild;while(n){dom.insertAfter(n.cloneNode(true),e);n=n.previousSibling}dom.remove(e)};return dom.run(e,function(e){e=ed.dom.get(e);d=d||e.ownerDocument||ed.getDoc();if(tinymce.isIE){try{if(tinymce.isIE&&e.nodeType==1)e.outerHTML=h;else setHTML(e,h,d)}catch(ex){setHTML(e,h,d)}}else setHTML(e,h,d)})}});tinymce.PluginManager.add('visualchars',tinymce.plugins.VisualChars)})();