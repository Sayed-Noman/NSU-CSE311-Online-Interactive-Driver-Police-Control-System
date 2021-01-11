const inputs = document.querySelectorAll(".input");

/*Function Implematation*/
function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}
/* Reste all textfiels on browser Refresh*/
var reset_input_values = document.querySelectorAll('.input');
for (var i = 0; i < reset_input_values.length; i++) {
  reset_input_values[i].value = '';
}

/*Function Declaration*/
inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});
