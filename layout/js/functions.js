
		function doActiveOptionNav(cla, classOption, classSelected) {
            const c = document.querySelectorAll(classOption);
                c.forEach(el => el.classList.toggle(classSelected, el === cla));
                
        }

		function teste(){
			alert(1);
		}

		// onkeydown="EnterKeyFilter();"
		// Desativa a Tecla Enter
		function getKey(key)
		{  
		  if (window.event.keyCode == key)
		  {   
//			document.querySelector(".ocultFirst").click(); // Se precisar que ele aperte algum botão
			event.preventDefault();
			event.returnValue=false;
			event.cancel = true;
		  }
		}


		$(document).ready(function() {
			Tipped.create('.tooltip');
		});


		function onToggle(element) {
		    $(element).toggle();
        }


		$('.flip-container .flipper').click(function() {
			$(this).closest('.flip-container').toggleClass('hover');
			$(this).css('transform, rotateY(180deg)');
		});
		
		function popupToggle(element, style){
            if(document.getElementById(element).style.display != style)
			    document.getElementById(element).style.display =  style;
            else
			    document.getElementById(element).style.display =  "none";
		}
		