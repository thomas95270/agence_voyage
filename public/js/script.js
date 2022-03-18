$(document).ready(() => {
	let containerEtapes = $(".container-etapes");
	let addNewEtape = $(
		"<a class='btn btn-secondary text-light m-4' href='#'>Ajouter une nouvelle étape</a>"
	);
	containerEtapes.append(addNewEtape);
	containerEtapes.data("index", containerEtapes.find(".card-etape").length);

	/** ***********************************AJOUT BOUTON ETAPES AU FORMULAIRE DE PRODUIT***************************************************** */
	/** ***********************************fonction addNewForm***************************************************** */
	//fonction qui permet d'ajouter dynamiquement le formulaire d'ajout detapes au DOM
	function addNewForm() {
		let prototype = containerEtapes.data("prototype");
		let index = containerEtapes.data("index");
		let newForm = prototype;
		newForm = newForm.replace(/__name__/g, index);
		containerEtapes.data("index", ++index);

		let card = $('<div class="card-etape"></div>');
		card.append(newForm);
		addRemoveButton(card);
		addNewEtape.before(card);
	}

	addNewEtape.click(function (e) {
		e.preventDefault();
		addNewForm();
	});

	/** ***********************************fonction addRemoveButton***************************************************** */
	function addRemoveButton(card) {
		let removeButton = $(
			'<a class="btn btn-danger rounded-pill mb-3" href="#">Supprimer l\'étape</a>'
		);
		card.append(removeButton);
		removeButton.click(function (e) {
			e.preventDefault();
			$(card).slideUp(500, function () {
				$(this).remove();
			});
		});
	}
https://cdnjs.com/libraries/jquery
	containerEtapes.find(".card-etape").each(function () {
		addRemoveButton($(this));
	});

	/** ***********************************AJOUT BOUTON Participant AU FORMULAIRE DE RESERVATION***************************************************** */
	/** ***********************************fonction addNewForm***************************************************** */
	let containerParticipants = $(".container-participants");
	let addNewParticipant = $(
		"<a class='btn btn-secondary text-light m-3' href='#'>Ajouter un autre participant</a>"
	);

	containerParticipants.append(addNewParticipant);
	containerParticipants.data(
		"index",
		containerParticipants.find(".card-participant").length
	);

	//fonction qui permet d'ajouter dynamiquement le formulaire d'ajout de participant au DOM
	function addNewFormParticipant() {
		let prototype = containerParticipants.data("prototype");
		let index = containerParticipants.data("index");
		let newForm = prototype;
		newForm = newForm.replace(/__name__/g, index);
		containerParticipants.data("index", index + 1);
		let card = $(
			`<div class="card-participant card col-4 p-3"><div class="card-title">Participant ${
				index + 1
			}  </div></div>`
		);
		card.append(newForm);
		addRemoveButtonParticipant(card);
		addNewParticipant.before(card);
	}

	addNewParticipant.click(function (e) {
		e.preventDefault();
		addNewFormParticipant();
	});

	/** ***********************************fonction addRemoveButton***************************************************** */
	function addRemoveButtonParticipant(card) {
		let removeButton = $(
			'<a class="btn btn-danger" href="#">Supprimer le participant</a>'
		);
		card.append(removeButton);
		removeButton.click(function (e) {
			e.preventDefault();
			$(card).slideUp(500, function () {
				$(this).remove();
			});
		});
	}

	containerParticipants.find(".card-participant").each(function () {
		addRemoveButtonParticipant($(this));
	});
	// addRemoveButtonParticipant($(this));
});
