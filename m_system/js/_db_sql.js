function fill() 
{ 
 $.ajax
 (
	{   
		url: "js/fun/get_chipnum.php",   
		type: "GET",   
		dataType: "json",   
		success: function(json) 
		{  

			var NumOfData = json.length;
			if(NumOfData == 0){console.log("fill() : NumOfData == 0");}
			var select = document.getElementById("listbox_chip");
			document.getElementById("listbox_chip").options.length=0;
			select.options[select.options.length] = new Option("");
			for (var i = 0; i <NumOfData; i++) 
			{   
				//alert("Name: "+json[i]["_project_name"]);  
				
				select.options[select.options.length] = new Option(json[i]["_chip"]);				 
		   
			}	
			showchipdata("");
		} 
        
	}
 );		
}

function showchipdata(con_1) 
{  
var con_2 = document.getElementById('KEYWORD_text').value;
//alert("1."+con_1+" 2."+con_2);
 $.ajax
 (
	{   
		url: "js/fun/get_databychip.php",   
		type: "POST",  
        data: {chip: con_1,condition: con_2},
		dataType: "json",   
		error: function () {
                 alert("An error occurred");
            },
		success: function(json) 
		{  
            
			//var NumOfData = json.length;
			//console.log("");
			//for (var i = 0; i <NumOfData; i++) 
			//{   
			//	alert("1: "+json[i]["_chip"]);  
			//	alert("2: "+json[i]["_project_name"]);  
			//	alert("3: "+json[i]["_complete"]);  
			//}
			
			$("#filter_datalist").html("");
                var html;
                $.each(json, function (i, data) {
                    var j = 0;
                    j += i + 1;
                    html += "<tr><td>" + data._chip + "</td>";
                    html += "<td>" + data._project_name + "</td>";
					html += "<td>" + data._complete + "</td>";
					html += "<td>" + data._author + "</td>";
					html += "<td>" + data._last_update_date + "</td>";
					html += "</tr>";
                });
            $("#filter_datalist").html(html);

			  
		}   
	}
 );	 
}




