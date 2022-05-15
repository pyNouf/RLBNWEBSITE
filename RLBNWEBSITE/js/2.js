document.getElementsByTagName("button")[0].onclick = function() {
	let elem = document.getElementsByClassName("r_love");
	for (let i = 0; i < elem.length; i++) {
	  if (elem[i].style.display === "none") {
		elem[i].style.display = "block";
	  } else {
		elem[i].style.display = "none";
	  }
	}
};

document.getElementsByTagName("button")[1].onclick = function() {
	let elem = document.getElementsByClassName("r_hate");
	for (let i = 0; i < elem.length; i++) {
	  if (elem[i].style.display === "none") {
		elem[i].style.display = "block";
	  } else {
		elem[i].style.display = "none";
	  }
	}
};