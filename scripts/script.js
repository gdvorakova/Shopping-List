function increaseQuantity(button) {
    // get closest div ancestor (quantity div)
    // get input block which is descendant of quantity block
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

function decreaseQuantity(button) {
    // get closest div ancestor (quantity div)
    // get input block which is descendant of quantity block
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
    // get closest div ancestor (quantity div)
    // get input block which is descendant of quantity block
    let id = button.closest(".item").id;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            button.innerHTML = this.responseText;
        }
    };

    let url = "index.php?action=delete&id=" + id;
    xhttp.open("POST", url, true);
    xhttp.send();

    let itemBlock = document.getElementById(id);
    itemBlock.parentNode.removeChild(itemBlock);
}

/*function saveChanges(button) {
    // get closest div ancestor (quantity div)
    // get input block which is descendant of quantity block
    let id = button.closest(".item").id;
    let amount = button.closest(".item").querySelector("#amount").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            button.innerHTML = this.responseText;
        }
    };

    let url = "index.php?action=save-amount&id=" + id + "&amount=" + amount;
    xhttp.open("POST", url, true);
    xhttp.send();

    // disable clicking on the save button
    let item = button.closest(".item");
    let saveButton = item.querySelector(".save-changes-button");
    saveButton.disabled = true;
}*/

function saveChanges(event) {
    // get closest div ancestor (quantity div)
    // get input block which is descendant of quantity block
    let senderButton = event.target;

    let id = senderButton.closest(".item").id;
    let amount = senderButton.closest(".item").querySelector("#amount").value;

    var xhttp = new XMLHttpRequest();
    /* xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            senderButton.innerHTML = this.responseText;
        }
    }; */

    let url = "index.php?action=save-amount&id=" + id + "&amount=" + amount;
    xhttp.open("POST", url, true);
    xhttp.send();

    // disable clicking on the save button
    let item = senderButton.closest(".item");
    let saveButton = item.querySelector(".save-changes-button");
    saveButton.disabled = true;

    event.preventDefault();
}

