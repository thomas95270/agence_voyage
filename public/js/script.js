$(document).ready(() => {
	let containerEtapes = $(".container-etapes");
	let addNewEtape = $(
		"<button class='btn btn-secondary text-light' href='#'>Ajouter une nouvelle étape</button>"
	);
	containerEtapes.append(addNewEtape);
	containerEtapes.data("index", containerEtapes.find(".card-etape").length);

	let containerParticipants = $(".container-participants");
	let addNewParticipant = $(
		"<a class='btn btn-secondary text-light m-3' href='#'>Ajouter un autre participant</a>"
	);

	containerParticipants.append(addNewParticipant);
	containerParticipants.data(
		"index",
		containerParticipants.find(".card-participant").length
	);

	/** ***********************************AJOUT BOUTON ETAPES AU FORMULAIRE DE PRODUIT***************************************************** */
	/** ***********************************fonction addNewForm***************************************************** */
	//fonction qui permet d'ajouter dynamiquement le formulaire d'ajout detapes au DOM
	function addNewForm() {
		let prototype = containerEtapes.data("prototype");
		let index = containerEtapes.data("index");
		let newForm = prototype;
		newForm = newForm.replace(/__name__/g, index);
		containerEtapes.data("index", index++);

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
			'<button class="btn btn-danger" href="#">Supprimer l\'étape</button>'
		);
		card.append(removeButton);
		removeButton.click(function (e) {
			e.preventDefault();
			$(card).slideUp(500, function () {
				$(this).remove();
			});
		});
	}

	containerEtapes.find(".card-etape").each(function () {
		addRemoveButton($(this));
	});

	/** ***********************************AJOUT BOUTON Participant AU FORMULAIRE DE RESERVATION***************************************************** */
	/** ***********************************fonction addNewForm***************************************************** */

	//fonction qui permet d'ajouter dynamiquement le formulaire d'ajout de participant au DOM

	function addNewFormParticipant() {
		let prototype = containerParticipants.data("prototype");
		let index = containerParticipants.data("index");
		let newForm = prototype;
		newForm = newForm.replace(/__name__/g, index);
		containerParticipants.data("index", index++);

		let card = $('<div class="card-participant"></div>');
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
			'<button class="btn btn-danger" href="#">Supprimer le participant</button>'
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
	addRemoveButtonParticipant($(this));
});
