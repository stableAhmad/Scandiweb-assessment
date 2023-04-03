
//selecting the switcher in the html page
let switcher = document.getElementById("productType")

//selecting the cancel button in the html page
let cancel_button = document.getElementById("cancel")

let replaced = false;


//a function to add input fields for each type selected
function place(inner)
{
	document.getElementById("extra").innerHTML = types[inner]
	document.getElementById("messages").innerHTML = messages[inner]
	replaced = true;
}



//The following are html input fields for each type
book = `
<div class="form-group mb-3">
<lable>Weight (KG)</label>
<input class="collect"  name="weight" id="weight" >
</div>
`


dvd = `
<div class="form-group mb-3">
<lable>Size (MB)</label>
<input class="collect" name="size" id="size" >
</div>
`

furniture = `
<div class="form-group mb-3">
<label>Height (CM)</label>
<input class="collect" name="height" id="height" >
</div>

<div class="form-group mb-3">
<label>Width (CM)</label>
<input class="collect"  name="width" id="width" >
</div>

<div class="form-group mb-3">
<label>length (CM)</label>
<input class="collect" name="length" id="length" >
</div>
`


//mapping each type to its html input fields in a map called types
let types = {}
types["Book"] = book
types["DVD"] = dvd
types["Furniture"] = furniture

//mapping each type to its message in a map called messages
let messages = {}
messages["Book"] = "Please provide weight"
messages["DVD"] = "Please provide size"
messages["Furniture"] = "Please provide dimensions"


//trigerring the place function when the value of the switcher is changed
switcher.addEventListener("change" , function(event)
{
	place(event.target.value)
})

//changing the href when the cancel button is clicked
cancel_button.addEventListener("click", function(){
	window.location.href = "./index.php"
})


//sending the data entered by the user to the php file (add.php) by an ajax call when the save button is clicked
document.getElementById("add_button").addEventListener("click" , function (){

	let elements = document.forms["product_form"].getElementsByClassName("collect")
	let object = {};
	for(let i = 0 ; i < elements.length ; i++)
	{
		object[elements[i].name] = elements[i].value;
	}
	if(replaced)
	{
	$.ajax({

		type: "POST",

		url: "./php/add.php",

		data: object,

		success: function (back) {
			
			if(back === "1")
			{
				window.location.href = "./index.php";
			}
			else
			{

				document.getElementById("modal_content").innerHTML = back;
				document.getElementById("launch_modal").click();
				
			}
		}

	});
}else 
{
	//showing the following message if the type is not selected
	document.getElementById("modal_content").innerHTML = "Product type is necessary !";
	document.getElementById("launch_modal").click();
}

});
