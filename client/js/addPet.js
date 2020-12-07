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
