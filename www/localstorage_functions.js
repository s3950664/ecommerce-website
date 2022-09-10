function addToCart(product_name_only) {

    var product_name = document.getElementById(product_name_only).querySelector(".product_name").innerHTML;
    var vendor = document.getElementById(product_name_only).querySelector(".username").innerHTML;
    var product_price = document.getElementById(product_name_only).querySelector(".product_price").innerHTML;
    var product_id = document.getElementById(product_name_only).querySelector(".product_id").innerHTML;
    var product_description = document.getElementById(product_name_only).querySelector(".product_description").innerHTML;

    var button = document.getElementById(product_name_only).querySelector(".btn");

    button.style.backgroundColor = 'rgb(238, 0, 34)';
    button.style.border = 'none';
    button.innerHTML = 'Remove';
    button.setAttribute('onclick', 'removeFromCart("' + product_name_only + '")');

    var product = { 'product_name': product_name, 'vendor': vendor, 'product_price': product_price, 'product_id': product_id, 'product_description': product_description, 'product_name_only': product_name_only };
    saveDataToLocalStorage(product);
}

function saveDataToLocalStorage(data) {

    var a = [];
    a = JSON.parse(localStorage.getItem('products')) || [];
    a.push(data);
    localStorage.setItem('products', JSON.stringify(a));
}

function removeDataFromLocalStorage(username, product_id) {
    var a = [];
    a = JSON.parse(localStorage.getItem('products')) || [];
    for (var i = 0; i < a.length; i++) {
        if (a[i]['vendor'] == username && a[i]['product_id'] == product_id) {
            a.splice(i, 1);
        }
    }
    localStorage.setItem('products', JSON.stringify(a));
}

function redify() {
    var product = localStorage.getItem("products");
    var product = JSON.parse(product);
    if (product != null) {
        for (var i = 0; i < product.length; i++) {


            product_name_only = product[i]['product_name_only'];

            var button = document.getElementById(product_name_only).querySelector(".btn");
            button.style.backgroundColor = 'rgb(238, 0, 34)';
            button.style.border = 'none';
            button.innerHTML = 'Remove';
            button.setAttribute('onclick', 'removeFromCart("' + product_name_only + '")');
        }
    }
}

function removeFromCart(product_name_only) {
    var vendor = document.getElementById(product_name_only).querySelector(".username").innerHTML;
    var product_id = document.getElementById(product_name_only).querySelector(".product_id").innerHTML;
    var button = document.getElementById(product_name_only).querySelector(".btn");

    removeDataFromLocalStorage(vendor, product_id);

    button.removeAttribute('style');
    button.innerHTML = 'Add to cart';
    button.setAttribute('onclick', 'addToCart("' + product_name_only + '")');
}

