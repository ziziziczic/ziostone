	var scrollerwidth=218
	var scrollerheight=115  
	var scrollerbgcolor=''  
	var scrollerbackground=''  
	// °øÁö»çÇ× °¹¼ö
	var num =1
	// ¸ØÃß´Â ½Ã°£ Å¬¼ö·Ï ¿À·¡ ¸ØÃã
	var scrollspeed='2000'
	// Scrolling ¼Óµµ	
	var waitingtime='5'

	if (messages.length > 2)   
		i=2 
	else { 
	    if(messages.length == 1){
            messages[1] = messages[0]
		}            
		i=0
	}

	function move1(whichlayer){  
		tlayer=eval(whichlayer)  
		if (tlayer.top>0&&tlayer.top<=num){  
			tlayer.top=0  
			setTimeout("move1(tlayer)",scrollspeed)  
			setTimeout("move2(document.main.document.second)",scrollspeed)  
			return  
		}  
		if (tlayer.top>=tlayer.document.height*-1){  
			tlayer.top-=num
			setTimeout("move1(tlayer)",waitingtime)  
		}  
		else{  
			tlayer.top=scrollerheight  
			tlayer.document.write(messages[i])  
			tlayer.document.close()  
			if (i >= messages.length - 1)  
				i=0  
			else  
				i++  
		}  
	}  
               	
	function move2(whichlayer){  
		tlayer2=eval(whichlayer)  
		if (tlayer2.top>0&&tlayer2.top<=num){  
			tlayer2.top=0  
			setTimeout("move2(tlayer2)",scrollspeed)  
			setTimeout("move1(document.main.document.first)",scrollspeed)  
			return  
		}  
		if (tlayer2.top>=tlayer2.document.height*-1){  
			tlayer2.top-=num
			setTimeout("move2(tlayer2)",waitingtime)  
		}  
		else{  
			tlayer2.top=scrollerheight  
			tlayer2.document.write(messages[i])  
			tlayer2.document.close()  
			if (i >= messages.length - 1)  
				i=0  
			else  
				i++  
		}  
	}  

	function move3(whichdiv){  
		tdiv=eval(whichdiv)  
		if (tdiv.style.pixelTop>0&&tdiv.style.pixelTop<=num){  
			tdiv.style.pixelTop=0  
			setTimeout("move3(tdiv)",scrollspeed)  
			setTimeout("move4(second2)",scrollspeed)  
			return  
		}  
		if (tdiv.style.pixelTop>=tdiv.offsetHeight*-1){  
			tdiv.style.pixelTop-=num
			setTimeout("move3(tdiv)",waitingtime)  
		} else{  
			tdiv.style.pixelTop=scrollerheight  
			tdiv.innerHTML=messages[i]  
			if (i >= messages.length - 1)  
				i=0  
			else  
				i++  
		}  
	}  
                      	  
	function move4(whichdiv){  
		tdiv2=eval(whichdiv)  
		if (tdiv2.style.pixelTop>0&&tdiv2.style.pixelTop<=num){  
			tdiv2.style.pixelTop=0  
			setTimeout("move4(tdiv2)",scrollspeed)  
			setTimeout("move3(first2)",scrollspeed)  
			return  
		}  
		if (tdiv2.style.pixelTop>=tdiv2.offsetHeight*-1){  
			tdiv2.style.pixelTop-=num  
			setTimeout("move4(second2)",waitingtime)  
		} else{  
			tdiv2.style.pixelTop=scrollerheight  
			tdiv2.innerHTML=messages[i]  
			if (i >= messages.length - 1)  
			i=0  
			else  
			i++  
		}  
	}  

	function onmouse_event(){
		num=0
	}

	function mouseout_event(){
		num=1
	}   

	function startscroll(){  
		if (document.all){  
			move3(first2)  
			second2.style.top=scrollerheight  
			second2.style.visibility='visible'  
		}  
		else if (document.layers){  
			document.main.visibility='show'  
			move1(document.main.document.first)  
			document.main.document.second.top=scrollerheight+num  
			document.main.document.second.visibility='show'  
		}  
	}  

	window.onload=startscroll  
                      
	document.writeln("<ilayer id='main' width='&{scrollerwidth};' height='&{scrollerheight};' bgColor='&{scrollerbgcolor};' background='&{scrollerbackground};' visibility='hide'>")

	document.writeln("<layer id='first' onMouseOver='onmouse_event()' onMouseOut='mouseout_event()' left='0' top='1' width='&{scrollerwidth};'>")

	if (document.layers)  
		document.write(messages[0])  

	document.writeln("</layer>")

	document.writeln("<layer id='second' onMouseOver='onmouse_event()' onMouseOut='mouseout_event()' left='0' top='0' width='&{scrollerwidth};' visibility='hide'> ")

	if (document.layers)  
		document.write(messages[1])  

	document.writeln("</layer>")

	document.writeln("</ilayer>")

	if (document.all){  
		document.writeln('<span id="main2" style="position:relative;width:'+scrollerwidth+';height:'+scrollerheight+';overflow:hiden;background-color:'+scrollerbgcolor+' ;background-image:url('+scrollerbackground+')">')  

		document.writeln('<div onMouseOver="onmouse_event()" onMouseOut="mouseout_event()" style="position:absolute;width:'+scrollerwidth+';height:'+scrollerheight+';clip:rect(0 '+scrollerwidth+' '+scrollerheight+' 0);left:0;top:0">')  
		document.writeln('<div id="first2" style="position:absolute;width:'+scrollerwidth+';left:0;top:1;">')
		document.write(messages[0])
		document.writeln('</div>')

		document.writeln('<div id="second2" style="position:absolute;width:'+scrollerwidth+';left:0;top:0;visibility:hidden">')
		document.write(messages[1])
		document.writeln('</div>')

		document.writeln('</div>')

		document.writeln('</span>')
	}

