function displayVendor(x) {
    if (x.checked) {
        document.getElementById("vendorField").style.display = "initial";
        document.getElementById("customerField").style.display = "none";
        document.getElementById("shipperField").style.display = "none";
        //REMOVE REQUIRED ATTRIBUTE FROM ALL OTHER INPUTS
        removeAllRequiredAttribute();
        //ADD REQUIRED ATTRIBUTE TO ALL INPUTS FROM VENDOR FIELD
        addRequiredAttributeToField("vendorField");
    }
}
 
function displayCustomer(x) {
    if (x.checked) {
        document.getElementById("vendorField").style.display = "none";
        document.getElementById("customerField").style.display = "initial";
        document.getElementById("shipperField").style.display = "none";
        //REMOVE REQUIRED ATTRIBUTE FROM ALL OTHER INPUTS
        removeAllRequiredAttribute();
        //ADD REQUIRED ATTRIBUTE TO ALL INPUTS FROM CUSTOMER FIELD
        addRequiredAttributeToField("customerField");
    }
}

function displayShipper(x) {
    if (x.checked) {
        document.getElementById("vendorField").style.display = "none";
        document.getElementById("customerField").style.display = "none";
        document.getElementById("shipperField").style.display = "initial";
        //REMOVE REQUIRED ATTRIBUTE FROM ALL OTHER INPUTS
        removeAllRequiredAttribute();
        //ADD REQUIRED ATTRIBUTE TO ALL INPUTS FROM SHIPPER FIELD
        addRequiredAttributeToField("shipperField");
    }
}

function addRequiredAttributeToField(field) {
    var Input = document.getElementById(field).getElementsByTagName("input");
    console.log(Input);
    for(i = 0; i < Input.length; i++) {
        Input[i].setAttribute("required", "");
    }
}

function removeAllRequiredAttribute() {
    var requiredInput = document.querySelectorAll("[required]");
    for(i = 0, l = requiredInput.length; i < l; i++) {
        requiredInput[i].removeAttribute("required");
    }
}



