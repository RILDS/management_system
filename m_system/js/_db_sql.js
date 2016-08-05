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

function showchipdata2()
{
  //var con_2 = document.getElementById('KEYWORD_text').value;
  //alert("showchipdata2!");
  con_1 = "";
  con_2 = "";
 $.ajax
 (
	{
		url: "js/fun/get_templete.php",
		type: "POST",
		data: {chip: con_1,condition: con_2},
		dataType: "json",
		error: function () {
		alert("An error occurred");
		},
		success: function(json)
		{
			//alert("An success");
			$("#fill_Templetelist").html("");
			var html;
			$.each(json, function (i, data) {
				var j = 0;
				j += i + 1;
				html += "<tr><td><a href=\"CheckingList_Create.html?temp="+data._templete_name+"\">" + data._templete_name + "</a></td></tr>";

			});
			$("#fill_Templetelist").html(html);
		}
	}
 );
}




