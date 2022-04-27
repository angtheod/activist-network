let form    = document.getElementById("form");
let input   = document.getElementById("activist-name");
let buttons = document.querySelectorAll(".activist-btn");

buttons.forEach(el => el.addEventListener('click', event => {
    input.value = el.getAttribute("data-val");
    form.submit();
}));
