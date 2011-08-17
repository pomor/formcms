
function addToFavorite(id,otype,obj,isfull)
{
	$.ajax({
		url: '/favorite/add',
		type: "POST",
		data: {id:id, otype:otype},
		dataType: "html",
		success: function(data){
			
			var adds = (isfull)?'full':'klein';
			
			
			if(data.indexOf("OK") != -1)
			{	
				$(obj).children('img').attr('src',"/stylespace/template1/images/_neue-buttons/plus_"+adds+"_gruen.png");
			}
			else if(data.indexOf("DEL") != -1)
			{	
				$(obj).children('img').attr('src',"/stylespace/template1/images/_neue-buttons/plus_"+adds+"_grau.png");
			}
			else
				{
					alert(data);
				}
			
			//clearWaitStatus(obj);
		},
		beforeSend: function(){
			//setWaitStatus(obj);
		}		
		
	});
}

function addToMysoft(lid,obj,isfull)
{
	$.ajax({
		url: '/mysoft/add',
		type: "POST",
		data: {lid:lid},
		dataType: "html",
		success: function(data){
			if(data.indexOf("OK")>=0)
			{	
				$(obj).html('Installed');							
				if(isfull)
					$(obj).parent().removeClass().addClass('activefull');
				else
					$(obj).parent().removeClass().addClass('active');
				
				
			}	
			else
				{
				alert(data);
				}
			
		},
		beforeSend: function(){
			
		}		
		
	});
}


function getWaiteDiv(withControl)
{
	
	var divname = withControl?"waitsttausdoc":"waitsttaus";
	
	var waitdivdoc = "<div class='"+divname+"' align='center'>";
	if(withControl)
	{
		waitdivdoc += "<div id='control'><a href='#' onclick='clearWaitStatusDocument(); return false;'>Schlißen<img src='/stylespace/template1/images/delete.png' align='right'></a></div>";
	}
	waitdivdoc += "<div id='ajax_content'>Load...<br><img src='/stylespace/template1/images/spinner.gif'></div></div>";
	
	return $(waitdivdoc);
}

function checkJavaAction()
{	
	try
	{
		$(".javaaction").each(function(index){
			try{
				var tmp = $(this).html();
				$(this).remove();
				eval(tmp);				
			}catch(ex_){}});
	}
	catch(ex_){}
}


function setWaitStatus(obj)
{
	var p = $(obj).parent().position();
	var w = $(obj).parent().width();
	var h = $(obj).parent().height();	
	
	var nelm=getWaiteDiv(false);
	nelm.css({top: p.top, left: p.left, width: w, height: h, 
		position: "absolute", "z-index":300, "background-color": "#cccccc"});
		
	$(obj).parent().prepend(nelm);	
	
	return nelm;
	
}

function setWaitStatusKind(obj)
{
	$(obj).html("<div style='background-color: #eeeeee'><br>Load...<br><img src='/stylespace/template1/images/spinner.gif'><br></div>");	
}


function setWaitStatusDocument()
{		
	var nelm=getWaiteDiv(true);
		
	$('body').append(nelm);
	
}

function clearWaitStatusDocument()
{	
	$(".waitsttausdoc").remove();
}


function clearWaitStatus()
{	
	$(".waitsttaus").remove();
}

function fg_AjaxLoad(obj,urls,formcontent)
{
	$.ajax({
			url: urls,
			type: "POST",
			data: formcontent,
			dataType: "html",
			success: function(data){
				$(obj).html(data);	
				clearWaitStatus(obj);
			},
			beforeSend: function(){
				setWaitStatus(obj);
			}		
			
	});
	
}


function sendAjaxFormJson(formobj,showobject,callbackfunc)
{

	var waitobj = null;
	var content = $(formobj).serialize();	
	var act=$(formobj).attr('action');
	
	$.ajax({
		url: act,
		type: 'POST',
		data: content,
		dataType: "json",
		success: function(data){
			callbackfunc(data);	
			waitobj.remove();
		},		
		beforeSend: function(){			
			waitobj=setWaitStatus(showobject);					
		}	

	});

}


function sendAjaxForm(formobj,showobject)
{
	updateScEditor();
	var content = $(formobj).serialize();
	
	var act=$(formobj).attr('action')||'/index.php';
	
	$.ajax({
		url: act,
		type: 'POST',
		data: content,
		dataType: "html",
		success: function(data){
			$(showobject).html(data);
			setScEditor();
		},		
		beforeSend: function(){			
			setWaitStatusKind(showobject);					
		}	

	});

}

function updateScEditor()
{
	$name=".visualEditor";
	
	if(arguments.length>0)
			$name=arguments[0];
	
	
	
	var $editors = $($name);
		    if ($editors.length) {
		        $editors.each(function() {
		            var editorID = $(this).attr("id");
		            var instance = CKEDITOR.instances[editorID];
		            if (instance) { instance.destroy(); }

		        });
			}
}

function setScEditor()
{
	$name=".visualEditor";
	
	if(arguments.length>0)
			$name=arguments[0];
	
	var $editors = $($name);
		    if ($editors.length) {
		        $editors.each(function() {
		            var editorID = $(this).attr("id");
		            var instance = CKEDITOR.instances[editorID];
		            if (instance) { instance.destroy(true); }
		            CKEDITOR.replace(editorID,{filebrowserBrowseUrl : '/extmodule/elFinder/elfinder.php'});
		        });
			}
}


function getPermissions(divname,clickobj)
{
	var divobject = $('#'+divname); 
	
	
	if(divobject.is(':visible'))
	{	
		divobject.slideUp('fast');
		$(clickobj).html('Show Custom Permissions');
	}
	else
	{
		
		$.ajax({
			url: '/index.php',
			type: 'POST',
			data: {evt: 'perm'},
			dataType: "html",
			success: function(data){			
				divobject.hide().html(data).slideDown('fast');				
				$(clickobj).html('Hide Custom Permissions');
			},
			beforeSend: function(){
				setWaitStatusKind(divobject);								
				divobject.slideDown('fast');
			}

		});
	}
	
	
}



/**
 * realisierung Thread.sleep()
 * 
 * @param milliseconds
 */
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

/**
 * Prüft variablen
 * 
 * @param $vname
 * @param $check_type
 * @returns mixed
 */
function fg_CheckVals($vname,$check_type)
{
	$check_status = false;

	switch ($check_type)
	{
		case 'MSK_ZAHL':
			$vname=Number($vname);
			$check_status = !isNaN($vname);
			break;

		case 'MSK_FLOAT':
			$vname=parseFloat($vname);
			$check_status = !isNaN($vname);
			break;

		case 'MSK_INT':
			$vname=parseInt($vname);
			$check_status = !isNaN($vname);
			break;

		case 'MSK_EMAIL':
			$check_status = $vname.match(/^[a-zA-Z0-9\-_\.]+@[a-zA-Z0-9\-_\.]+\.[a-z0-9]{2-4}$/);
			break;

		case 'MSK_LOGIN':
			$check_status = $vname.match(/^[^'\"]+$/);
			break;

		case 'MSK_PASSWORD':
			$check_status = $vname.match(/^[^'\"]+$/);
			break;


		case 'MSK_DATE':
			var ch_string=/^([0-9]{1,4})[^0-9]+([0-9]{1,2})[^0-9]+([0-9]{1,4})$/;
			var $found = ch_string.exec($vname);


			if($found)
			{
				if($found[1].length==4)
				{
					$vname = String.sprintf("%02d.%02d.%04d",$found[3],$found[2],$found[1]);
				}
				else
				{
					$vname = String.sprintf("%02d.%02d.%04d",$found[1],$found[2],$found[3]);
				}
				$check_status=true;
			}

			break;

		case 'MSK_SAFESTRING':
			$check_status = $vname.match(/^[a-zA-Z0-9\-_\.]*$/);
			break;

	}

	return ($check_status?$vname:null);
}


function fg_Template(templateObj,content)
{
	var text = $('<textarea/>').html($(templateObj).html()).val();
	
	for(var k in content)
	{
		text=text.replace(new RegExp("#"+k+"#","g"),content[k]);
	}
	
	return text;

}

/* formatierte output */
function sprintf() {
	 if( sprintf.arguments.length < 2 ) {
	  return;
	 }

	 var data = sprintf.arguments[ 0 ];

	 for( var k=1; k<sprintf.arguments.length; ++k ) {

	  switch( typeof( sprintf.arguments[ k ] ) )
	  {
	   case 'string':
	    data = data.replace( /%s/, sprintf.arguments[ k ] );
	    break;
	   case 'number':
	    data = data.replace( /%d/, sprintf.arguments[ k ] );
	    break;
	   case 'boolean':
	    data = data.replace( /%b/, sprintf.arguments[ k ] ? 'true' : 'false' );
	    break;
	   default:
	    /// function | object | undefined
	    break;
	  }
	 }
	 return( data );
	}



window.setInterval("checkJavaAction()", 300);