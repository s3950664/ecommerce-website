function initialize() {
    table = document.getElementById("table");

    product = localStorage.getItem("products");
    product = JSON.parse(product);

    if (product != null) {
        for (var i = 0; i < product.length; i++) {
            var row = document.createElement("tr");
            //type="text" name="country" value="Norway" readonly

            if (product[i]['product_id'] == 0) {
                pno = product[i]['vendor'];
            } else {
                pno = product[i]['vendor'] + '_' + product[i]['product_id'];
            }

            pno = product[i]['product_name_only'];

            var heading = document.createElement("th");
            heading.setAttribute('scope', 'row');
            var product_name = document.createElement('td');
            var vendor = document.createElement('td');
            var product_price = document.createElement('td');
            var product_id = document.createElement('td');
            var button_td = document.createElement('td');
            var product_description = document.createElement('td');
            var button = document.createElement('a');


            var input_product_name = document.createElement('input');
            var input_vendor = document.createElement('input');
            var input_product_price = document.createElement('input');
            var input_product_id = document.createElement('input');
            var input_product_description = document.createElement('input');

            input_product_name.setAttribute('type', 'text')
            input_product_name.setAttribute('name', 'product[' + i + '][product_name]');
            input_product_name.setAttribute('value', product[i]['product_name']);
            input_product_name.setAttribute('readonly', true);

            input_vendor.setAttribute('type', 'text')
            input_vendor.setAttribute('name', 'product[' + i + '][vendor]');
            input_vendor.setAttribute('value', product[i]['vendor']);
            input_vendor.setAttribute('readonly', true);

            input_product_price.setAttribute('type', 'number')
            input_product_price.setAttribute('name', 'product[' + i + '][product_price]');
            input_product_price.setAttribute('value', product[i]['product_price']);
            input_product_price.setAttribute('readonly', true);

            input_product_id.setAttribute('type', 'number')
            input_product_id.setAttribute('name', 'product[' + i + '][product_id]');
            input_product_id.setAttribute('value', product[i]['product_id']);
            input_product_id.setAttribute('readonly', true);

            input_product_description.setAttribute('type', 'text')
            input_product_description.setAttribute('name', 'product[' + i + '][product_description]');
            input_product_description.setAttribute('value', product[i]['product_description']);
            input_product_description.setAttribute('readonly', true);

            product_name.appendChild(input_product_name);
            vendor.appendChild(input_vendor);
            product_price.appendChild(input_product_price);
            product_id.appendChild(input_product_id);
            product_description.appendChild(input_product_description);

            button.innerHTML = 'Remove';
            heading.innerHTML = i + 1;



            button.setAttribute('onclick', 'remove("' + pno + '")');
            button.setAttribute('class', 'btn btn-primary');
            button.setAttribute('style', 'background-color: rgb(238, 0, 34); border: none;');
            product_id.setAttribute('class', 'product_id');
            vendor.setAttribute('class', 'vendor');

            button_td.appendChild(button);
            row.setAttribute("id", pno);
            row.appendChild(heading); row.appendChild(product_name); row.appendChild(vendor); row.appendChild(product_id); row.appendChild(product_price); row.append(product_description); row.appendChild(button_td);
            table.appendChild(row);
        }
    }

}

function removeDataFromLocalStorage(product_name_only) {
    var a = [];
    a = JSON.parse(localStorage.getItem('products')) || [];
    for (var i = 0; i < a.length; i++) {
        if (a[i]['product_name_only'] == product_name_only) {
            a.splice(i, 1);
        }
    }
    localStorage.setItem('products', JSON.stringify(a));
}

function remove(product_name_only) {

    removeDataFromLocalStorage(product_name_only);
    document.getElementById(product_name_only).remove();
}

function deleteLocalStorage() {
    localStorage.clear();
}