function showSelected(thisObj)
{
	document.getElementById('subject_code_delete').value = thisObj.options[thisObj.selectedIndex].text; 
}

function showUpdateSelected(thisObj)
{
   document.getElementById('subject_code_update').value = thisObj.options[thisObj.selectedIndex].text;
}

function testing()
{
	console.log("hello");
}

function gethidden() 
{
    var fn = document.getElementById("hiddenFormName").value;
    console.log(fn);
    if (fn == "") return;
	if(fn == 0){
		document.getElementById("searchForm").style.display = "block";
	}
	else if(fn == 1){
		document.getElementById("addForm").style.display = "block";
	}
	else if(fn == 2){
		document.getElementById("updateForm").style.display = "block";
	}
	else if(fn == 3){
		document.getElementById("deleteForm").style.display = "block";
	}
}

function showForm()
				{
					var e = document.getElementById("selectForm");
					var value = e.options[e.selectedIndex].value;
					console.log(value);
					if(value == 0){
						document.getElementById("addForm").style.display = "none";
						document.getElementById("deleteForm").style.display = "none";
						document.getElementById("searchForm").style.display = "block";
						document.getElementById("updateForm").style.display = "none";
						
						document.getElementById("fn0").value = "0";
					}
					else if(value == 1){
						document.getElementById("addForm").style.display = "block";
						document.getElementById("deleteForm").style.display = "none";
						document.getElementById("searchForm").style.display = "none";
						document.getElementById("updateForm").style.display = "none";
						
						document.getElementById("fn1").value = "1";
					}
					else if(value == 2){
						document.getElementById("addForm").style.display = "none";
						document.getElementById("deleteForm").style.display = "none";
						document.getElementById("searchForm").style.display = "none";
						document.getElementById("updateForm").style.display = "block";
						
						document.getElementById("fn2").value = "2";
					}
					else if(value == 3){
						document.getElementById("addForm").style.display = "none";
						document.getElementById("deleteForm").style.display = "block";
						document.getElementById("searchForm").style.display = "none";
						document.getElementById("updateForm").style.display = "none";
						
						document.getElementById("fn3").value = "3";
					}
				}