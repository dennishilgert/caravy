// * ------------------------------
// * Submit form data via ajax
// * ------------------------------

document.addEventListener("submit", function (e) {
	e.preventDefault();
	var callback = function (status, response) {
		document.getElementById("response").innerHTML = response;
	};
	ajax("POST", e.target.getAttribute("action"), callback, e.target);
});

var ajax = function (method, action, callback, form) {
	var data = serialize(form);
	var request = new XMLHttpRequest();
	request.open(method, action);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.onload = function () {
		callback(request.status, request.responseText);
	};
	request.send(data);
};

var serialize = function (form) {
	var serialized = [];

	for (var i = 0; i < form.elements.length; i++) {
		var field = form.elements[i];
		if (!field.name || field.disabled || field.type === "file" || field.type === "reset" || field.type === "submit" || field.type === "button") {
			continue;
		}
		if (field.type === "select-multiple") {
			for (var n = 0; n < field.options.length; n++) {
				if (!field.options[n].selected) continue;
				serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
			}
		} else if ((field.type !== "checkbox" && field.type !== "radio") || field.checked) {
			serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
		}
	}
	return serialized.join("&");
};
