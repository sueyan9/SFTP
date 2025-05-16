// JavaScript Document

function makeTable(){
	var theTable =document.getElementById("tbl");
	//IE requires rows to be added to a tBody element
	//IE automatically creates a tBody element - delete it and then manually create
	if (theTable.firstChild != null){
		var badIEBody = theTable.childNodes[0];  
		theTable.removeChild(badIEBody);
	}
	var tBody = document.createElement("TBODY");
	theTable.appendChild(tBody);

	var newRow = document.createElement("tr");
	var c1 = document.createElement("td");
	var v1 = document.createTextNode("7308");
	c1.appendChild(v1);
	newRow.appendChild(c1);
	var c2 = document.createElement("td");
	var v2 = document.createTextNode("software engineering");
	c2.appendChild(v2);
	newRow.appendChild(c2);
	tBody.appendChild(newRow);

	newRow = document.createElement("tr");
	c1 = document.createElement("td");
	v1 = document.createTextNode("7003");
	c1.appendChild(v1);
	newRow.appendChild(c1);
	c2 = document.createElement("td");
	v2 = document.createTextNode("Web Development");
	c2.appendChild(v2);
	newRow.appendChild(c2);
	tBody.appendChild(newRow);
}

function appendRow() {
    // get the table and tbody elements
    var theTable = document.getElementById("tbl");
    var tBody = theTable.getElementsByTagName("tbody")[0];

    // get user input
    var courseCode = prompt("Enter course code:", "7001");
    var courseName = prompt("Enter course name:", "Database Systems");

    if (courseCode && courseName) {
        // create a new row
        var newRow = document.createElement("tr");
        newRow.className = "new"; 

        // create cell 1
        var cell1 = document.createElement("td");
        var val1 = document.createTextNode(courseCode);
        cell1.appendChild(val1);
        newRow.appendChild(cell1);

        // create cell 2
        var cell2 = document.createElement("td");
        var val2 = document.createTextNode(courseName);
        cell2.appendChild(val2);
        newRow.appendChild(cell2);

        // add the new row to the table
        tBody.appendChild(newRow);
    } else {
        alert("Both course code and name are required.");
    }
}

// Function to highlight the row when clicked
function selectRow(event) {
    var clickedRow = event.target.closest('tr'); // Get the row element

    if (!clickedRow.classList.contains("highlighted")) {
        // Remove highlight from any previously highlighted row
        var highlightedRows = document.querySelectorAll('.highlighted');
        highlightedRows.forEach(function(row) {
            row.classList.remove("highlighted");
        });

        // Highlight the clicked row
        clickedRow.classList.add("highlighted");
    }
}

// Function to remove the row if it is highlighted
function removeRow(event) {
    var clickedRow = event.target.closest('tr'); // Get the row element

    if (clickedRow.classList.contains("highlighted")) {
        clickedRow.parentNode.removeChild(clickedRow); // Remove the row from the table
    }
}



