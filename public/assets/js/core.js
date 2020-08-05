// * ------------------------------
// * Submit form data via ajax
// * ------------------------------

document.addEventListener("submit", function (e) {
	e.preventDefault();

	var callback = function (status, response) {
		if (status === 200) {
			var data = JSON.parse(response);
			Object.keys(data).forEach(function (key) {
				switch (key) {
					case "status":
						if (data[key] == "error") {
							var resetElements = document.getElementsByTagName("input");
							for (let element of resetElements) {
								element.blur();
								if (element.hasAttribute("resetOnError")) {
									element.value = "";
								}
							}
						}
						break;
					case "message":
						document.getElementById("response").innerHTML = data[key];
						break;
					case "redirect":
						var location = data[key]["location"];
						var delay = data[key]["delay"];
						if (delay != null) {
							setTimeout(function () {
								window.location.replace(location);
							}, delay * 1000);
						} else {
							window.location.replace(location);
						}
						break;
				}
			});
		}
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
