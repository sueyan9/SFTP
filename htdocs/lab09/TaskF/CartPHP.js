function loadCatalogue() {
    fetch("data/catalogue.json")
        .then(response => response.json())
        .then(data => {
            let catalogueDiv = document.getElementById("catalogue");
            let output = "";

            data.forEach(book => {
                output += `
                    <div>
                        <h3>${book.title}</h3>
                        <p>ISBN: ${book.isbn}</p>
                        <p>price: $${book.price.toFixed(2)}</p>
                        <a href="#" onclick="AddToCart(${book.id}, '${book.title}', ${book.price})">Add To Shopping Cart</a>
                    </div><hr/>
                `;
            });

            catalogueDiv.innerHTML = output;
        });
}

let cartItems = [];

function AddToCart(id, title, price) {
    // check if the item is already in the cart
    let existing = cartItems.find(item => item.id === id);
    if (existing) {
        existing.quantity++;
    } else {
        cartItems.push({ id, title, price, quantity: 1 });
    }
    updateCart();
}

function DeleteFromCart(id) {
    cartItems = cartItems.filter(item => item.id !== id);
    updateCart();
}

function updateCart() {
    const cartDiv = document.getElementById("cart");
    cartDiv.innerHTML = "";

    if (cartItems.length === 0) {
        cartDiv.innerHTML = "";
        return;
    }
    
  let total = 0;
    cartItems.forEach(item => {
        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        cartDiv.innerHTML += `
            <p>
                ${item.title} - $${item.price} x ${item.quantity} = $${itemTotal.toFixed(2)}
                <a href="#" onclick="DeleteFromCart(${item.id})">Remove Item</a>
            </p>
        `;
    });
    // calculate total price

    cartDiv.innerHTML += `<hr/><p><strong>Total Price : $${total.toFixed(2)}</strong></p>`;
    
}
