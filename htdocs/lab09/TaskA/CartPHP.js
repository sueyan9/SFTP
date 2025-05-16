function createRequest() {
    var req = false;
    try {
        req = new XMLHttpRequest(); // most modern browsers
    } catch (trymicrosoft) {
        try {
            req = new ActiveXObject("Msxml2.XMLHTTP"); // older IE
        } catch (othermicrosoft) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                req = false;
            }
        }
    }
    return req;
}

function AddToCart(id) {
    var book = document.getElementById("book" + id);
    var bookTitle = book.innerText;
    var isbn = document.getElementById("ISBN" + id).innerText;
    var price = document.getElementById("price" + id).innerText;
    var xhr = createRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            getData(xhr.responseXML);  
        }
    };
    xhr.open("GET", "ManageCart.php?action=Add&book=" +
        encodeURIComponent(bookTitle) + "&isbn=" +
        encodeURIComponent(isbn) + "&price=" +
        encodeURIComponent(price) + "&value=" + Number(new Date()), true);
    xhr.send(null);
}

function DeleteFromCart(id) {
    var book = document.getElementById("book"+ id).innerText;
    var xhr = createRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            getData(xhr.responseXML); 
        }
    };

    xhr.open("GET", "ManageCart.php?action=Remove&book=" +
        encodeURIComponent(book) + "&value=" + Number(new Date()), true);
    xhr.send(null);
}

function getData(responseXML) {
    var cartDisplay = document.getElementById("cart");

    if (responseXML == null) {
        cartDisplay.innerHTML = "";
    } else {
        var books = responseXML.getElementsByTagName("book");
        cartDisplay.innerHTML = "";
        for (var i = 0; i < books.length; i++) {
            var bookTitle = books[i].getElementsByTagName("title")[0].textContent;
            var bookPrice = books[i].getElementsByTagName("price")[0].textContent;
            var bookQuantity = books[i].getElementsByTagName("quantity")[0].textContent;

            cartDisplay.innerHTML += 
            bookTitle + " " 
            + bookQuantity + " " 
            + bookPrice + " " +

                "<a href='#' onclick='DeleteFromCart(" + (i + 1) + ")'>Remove Item</a><br>";
               
        }
    }
}


