function increaseAmount(button) {
    // get closest div ancestor (amount div)
    // get input block which is descendant of amount block
    let input = button.previousElementSibling;
    let count = parseInt(input.value);

    // increase count
    count++;

    input.value = count;

     // enable clicking on the save button
     let item = button.closest(".item");
     let saveButton = item.querySelector(".save-changes-button");
     saveButton.disabled = false;
}

function decreaseAmount(button) {
    // get closest div ancestor (amount div)
    // get input block which is descendant of amount block
    let input = button.nextElementSibling;
    let count = parseInt(input.value);

    if (count > 1) {
        // decrease count
        count--;
    }

    input.value = count;

    // enable clicking on the save button
    let item = button.closest(".item");
    let saveButton = item.querySelector(".save-changes-button");
    saveButton.disabled = false;
}

function deleteItem(button) {
    let id = button.closest(".item").id;

    var xhttp = new XMLHttpRequest();

    let url = "index.php?action=delete&id=" + id;
    xhttp.open("POST", url, true);

    xhttp.onreadystatechange = function () {
        if(xhttp.readyState == 4 || (xhttp.status == 200)) {
            let itemBlock = document.getElementById(id); 
            itemBlock.parentNode.removeChild(itemBlock);    
        }
      };

    xhttp.send();
}

function saveChanges(event) {
    let senderButton = event.target;

    let id = senderButton.closest(".item").id;
    let amount = senderButton.closest(".item").querySelector("#amount").value;

    var xhttp = new XMLHttpRequest();
    let url = "index.php?action=save-amount&id=" + id + "&amount=" + amount;
    xhttp.open("POST", url, true);
    xhttp.send();

    // disable clicking on the save button
    let item = senderButton.closest(".item");
    let saveButton = item.querySelector(".save-changes-button");
    saveButton.disabled = true;

    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData('target_id', event.target.id);
}

function allowDrop(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();  
    let dropTarget = event.target;

    let dragTargetId = event.dataTransfer.getData('target_id');

    if (event.currentTarget.id == dragTargetId) return false;
    let dragTarget = document.getElementById(dragTargetId);

    let tmp = document.createElement('span');
    tmp.className='hide';
    dropTarget.before(tmp);
    dragTarget.before(dropTarget);
    tmp.replaceWith(dragTarget);

    var xhttp = new XMLHttpRequest();

    let url = "index.php?action=swap&id1=" + dragTargetId + "&id2=" + event.currentTarget.id;
    xhttp.open("POST", url, true);
    xhttp.send();
}

function evaluateAmount(amountInput) {
    let amount = amountInput.value;

    var alreadyChecked = amountInput.classList.contains('is-invalid'); 

    if (amount.length == 0) {
        if (amountInput.classList.contains('is-invalid')) {
            amountInput.classList.remove('is-invalid');
        }

        if (amountInput.classList.contains('is-valid')) {
            amountInput.classList.remove('is-valid');
        }

        if (amountInput.closest(".field").querySelector(".message") != null) {
            let toDelete = amountInput.closest(".field").querySelector(".message");
            amountInput.closest(".field").removeChild(toDelete);
        }
        return false;
    }

    if (isNaN(amount)) {
        if (alreadyChecked) {
            amountInput.closest(".field").querySelector(".message").innerText = "The amount specified isn't a valid number.";
            return false;
        }

        // alert user
        // add red border around input field
        amountInput.classList.add('is-invalid');

        // print alert message
        var child = document.createElement("p");
        child.classList.add('message');
        child.classList.add('is-invalid');
        var node = document.createTextNode("The amount specified isn't a valid number.");
        child.appendChild(node);

        var parentField = amountInput.closest(".field");
        parentField.appendChild(child);

        return false;
    }

    let val = parseInt(amount);

	if (val == null || val < 1) {
        if (alreadyChecked) {
            amountInput.closest(".field").querySelector(".message").innerText = "The amount must be greater than 0.";
            return false;
        }

        // alert user
        // add red border around input field
        amountInput.classList.add('is-invalid');

        // print alert message
        child = document.createElement("p");
        child.classList.add('message');
        child.classList.add('is-invalid');
        child.id = "message";

        var node = document.createTextNode("The amount must be greater than 0.");
        child.appendChild(node);

        var parentField = amountInput.closest(".field");
        parentField.appendChild(child);

        return false;
    }

    if (amountInput.classList.contains('is-invalid')) {
        amountInput.classList.remove('is-invalid');
    }

    if (amountInput.closest(".field").querySelector(".message") != null) {
        let toDelete = amountInput.closest(".field").querySelector(".message");
        amountInput.closest(".field").removeChild(toDelete);
    }

    amountInput.classList.add('is-valid');
    return true;   
}

function evaluateName(nameInput) {
    var alreadyChecked = nameInput.classList.contains('is-invalid'); 

    if (nameInput.value.length == 0) {
        if (nameInput.classList.contains('is-invalid')) {
            nameInput.classList.remove('is-invalid');
        }

        if (nameInput.classList.contains('is-valid')) {
            nameInput.classList.remove('is-valid');
        }

        if (nameInput.closest(".field").querySelector(".message") != null) {
            let toDelete = nameInput.closest(".field").querySelector(".message");
            nameInput.closest(".field").removeChild(toDelete);
        }
        return false;
    }

    let match = false;

    let items = document.getElementsByClassName('item');

    for (let i = 0; i < items.length; i++) {
        const element = items[i];

       for (let j = 0; j < element.childNodes.length; j++) {
           const child = element.childNodes[j];

           if (child.className=="item-name") {
               if(child.innerText == nameInput.value.trim()) {
                   match = true;
                   break;
               }
           }     
       }
    }

    if (match) {
        if (alreadyChecked) return false;
        // alert user 

        // add red border around input field
        nameInput.classList.add('is-invalid');

        // print alert message
        var child = document.createElement("p");
        child.classList.add('message');
        child.classList.add('is-invalid');
        var node = document.createTextNode("This item already exists in your shopping list.");
        child.appendChild(node);
        child.id = "message";

        var parentField = nameInput.closest(".field");
        parentField.appendChild(child);

        return false;
    }

    if (nameInput.classList.contains('is-invalid')) {
        nameInput.classList.remove('is-invalid');
    }

    if (nameInput.closest(".field").querySelector(".message") != null) {
        let toDelete = nameInput.closest(".field").querySelector(".message");
        nameInput.closest(".field").removeChild(toDelete);
    }

    nameInput.classList.add('is-valid');
    return true;   
}

function checkForm() {
    var formInputs = document.getElementById("add-item-form");
    var enableSubmit = false;

    // check name field
    if (evaluateName(formInputs.elements["name"]) & evaluateAmount(formInputs.elements["amount"])) {
        enableSubmit = true;
    }

    if (enableSubmit) {
        document.getElementById('submit-input').disabled = false;
    }
    else {
        document.getElementById('submit-input').disabled = 'disabled';
    }
}

function removeInputText() {
    var formInputs = document.getElementById("add-item-form");
    formInputs.elements["name"].value = "";
    formInputs.elements["name"].classList.remove('is-valid');

    formInputs.elements["amount"].value = "";
    formInputs.elements["amount"].classList.remove('is-valid');
}

