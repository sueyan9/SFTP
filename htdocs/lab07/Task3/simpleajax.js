function getData(dataSource, divID, aName, aPwd) {
    var place = document.getElementById(divID);
    var requestBody = "name=" + encodeURIComponent(aName) + "&pwd=" + encodeURIComponent(aPwd);

    var url = "http://localhost:8000/" + dataSource;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: requestBody
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(function(text) {
      
        if (text.includes('error') || text.includes('not found') || text.includes('incorrect')) {
            alert(text); 
        } else {
            place.innerHTML = text;
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        place.innerHTML = "An error occurred while fetching data.";
    });
}
