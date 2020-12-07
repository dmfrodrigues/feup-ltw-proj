function addPetPhoto(element) {
	let inputs = element.querySelector("#pet-photos-inputs");
	let imgs = element.querySelector("#pet-photos-row");
	let num_inputs = element.querySelector("#photo-number");
	let N = parseInt(num_inputs.value);
	// Input
	let input = document.createElement("input");
	input.id = `pet-picture-${N}-input`;
	input.name = `pet-picture-${N}-input`;
	input.type = "file";
	input.style.display = "none";
	inputs.appendChild(input);
	// Img
	let img = document.createElement("img");
	img.id = `pet-picture-${N}-img`;
	img.onclick = function() {removeAddedPetPhoto(element, this.id);};
	imgs.appendChild(img);

	// Bind
	input.onchange = function () {
		let id = input.id.split("-")[2];
		let file = input.files[0];
		let img = input.parentNode.parentNode.querySelector(
			`#pet-picture-${id}-img`
		);
		updateImgFromFile(img, file);
	};
	// Num_inputs
	N += 1;
	num_inputs.value = `${N}`;
	// Click
	input.click();
}

function removeAddedPetPhoto(element, _id){
	let id = _id.split("-")[2];
	let inputs = element.querySelector("#pet-photos-inputs");
	let num_inputs = element.querySelector("#photo-number");
	let imgs = element.querySelector("#pet-photos-row");
	
	inputs.removeChild(document.getElementById(`pet-picture-${id}-input`));
	imgs.removeChild(document.getElementById(`pet-picture-${id}-img`));

	let N = parseInt(num_inputs.value);
	
	for(let i = parseInt(id); i < N - 1; i++){
		let _input = document.getElementById(`pet-picture-${i + 1}-input`);
		_input.id = `pet-picture-${i}-input`;
		_input.name = `pet-picture-${i}-input`;

		let img = document.getElementById(`pet-picture-${i + 1}-img`);
		img.id = `pet-picture-${i}-img`;
		img.onclick = `removeAddedPetPhoto(${i})`;
	}

	N -= 1;
	num_inputs.value = `${N}`;
}
