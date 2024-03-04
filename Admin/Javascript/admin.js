var newUnitInput; // Declare newUnitInput variable in a broader scope

    function fetchUnits() {
        var subjectSelect = document.getElementById('subject');
        var unitSelect = document.getElementById('unit');
        newUnitInput = document.getElementById('new_unit_input'); // Assign value to newUnitInput

        // Reset the unit dropdown and hide the new unit input
        unitSelect.innerHTML = '';
        newUnitInput.style.display = 'none';

        // If 'Add New Subject' is selected, show the new subject input
        if (subjectSelect.value === 'add_new_subject') {
            toggleSubjectInput(true);
            newUnitInput.style.display = "block";
        } else {
            // Use fetch to simplify the AJAX request
            fetch(`./Backend/fetch_units.php?subject=${encodeURIComponent(subjectSelect.value)}`)
                .then(response => response.json())
                .then(units => {
                    console.log(units);
                    units.forEach(unit => {
                        var option = new Option(unit, unit);
                        unitSelect.add(option);
                    });
                })
                .catch(error => console.error('Error fetching units:', error));

            var Option2 = new Option('Choose Unit', '');
            unitSelect.add(Option2);

        }

        var addNewUnitOption = new Option('Add new unit', 'add_new_unit');
        unitSelect.add(addNewUnitOption);



    }

    function toggleUnitInput() {
        var unitSelect = document.getElementById('unit');
        newUnitInput.style.display = (unitSelect.value === 'add_new_unit') ? 'block' : 'none';
    }

    function toggleSubjectInput(resetUnits) {
        var newSubjectInput = document.getElementById('new_subject_input');
        var thumbnailInput = document.getElementById('thumbnail_input');
        var des = document.getElementById('desc')

        newSubjectInput.style.display = 'block';
        thumbnailInput.style.display = 'block';
        des.style.display = "block";

        // Reset the unit dropdown and hide the new unit input if needed
        if (resetUnits) {
            toggleUnitInput();
        }
    }


    // Modify the toggleDeleteConfirmation function
    function toggleDeleteConfirmation(rowId) {
        var confirmation = confirm("Are you sure you want to delete this record?");
        if (confirmation) {
          console.log(" yes")
            // If user confirms, proceed with deletion
            deleteRecord(rowId);
        } else {
            // If user cancels, do nothing
        }
    }
   
    // Modify the deleteRecord function
    function deleteRecord(rowId) {
        console.log("inside delete")
        fetch(`./Backend/delete.php?id=${rowId}`, {
            method: 'DELETE',
            credentials: 'same-origin', // or 'include' if cross-origin with credentials
            headers: {
                'Content-Type': 'application/json', // Adjust content type if needed
                // Add other headers if necessary
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert("Record deleted successfully");
                location.reload();
            } else {
                alert(`Error deleting record: ${data.message}`);
            }
        })
        .catch(error => console.error('Error:', error));
    }


    //delete Price

    function toggleDeleteConfirmationPrice(rowId) {
        var confirmation = confirm("Are you sure you want to delete this record?");
        if (confirmation) {
          console.log(" yes")
            // If user confirms, proceed with deletion
            deletePriceRecord(rowId);
        } else {
            // If user cancels, do nothing
        }
    }
   
    // Modify the deleteRecord function
    function deletePriceRecord(rowId) {
        console.log("inside delete")
        fetch(`./Backend/deletePrice.php?id=${rowId}`, {
            method: 'DELETE',
            credentials: 'same-origin', // or 'include' if cross-origin with credentials
            headers: {
                'Content-Type': 'application/json', // Adjust content type if needed
                // Add other headers if necessary
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert("Record deleted successfully");
                location.reload();
            } else {
                alert(`Error deleting record: ${data.message}`);
            }
        })
        .catch(error => console.error('Error:', error));
    }


    
    
    

    function myFunction() {
        var x = document.getElementById("myNavbar");
        console.log(x.className);
        if (x.className === "navbar") {
          x.className += " responsive";
        } else {
          x.className = "navbar";
        }
      }
    
      document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission behavior
    
            // Get the form data
            var formData = new FormData(this);
    
            // Send the form data using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", this.action, true);
            xhr.onload = function () {
                console.log('XHR Response:', xhr.responseText);
                if (xhr.status === 200) {
                    // Log the response to the console for debugging
                    console.log(xhr.responseText);
    
                    // Check if the response is not empty
                    if (xhr.responseText.trim() !== "") {
                        try {
                            // Attempt to parse the JSON response
                            var response = JSON.parse(xhr.responseText);
    
                            if (response.status === 'success') {
                                // Data added successfully
                                alert("Data added successfully");
                                // You may perform additional actions here, e.g., clearing the form or updating the displayed data
                            } else {
                                // Handle the case when data addition fails
                                alert("Error adding data: " + response.message);
                            }
                        } catch (error) {
                            // Log any parsing errors
                            console.error("Error parsing JSON:", error);
                        }
                    } else {
                        // Handle the case when the response is empty
                        console.error("Empty response from the server");
                    }
                } else {
                    console.error("Error: " + xhr.status);
                }
            };
    
            xhr.send(formData);
        });
    });



    function addSubjectPrice() {
        // Get form data
        var formData = new FormData(document.getElementById("subjectPriceForm"));

        // AJAX request to add data to the "price" table
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./Backend/addPrice.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response
                alert(xhr.responseText);
                // You can perform additional actions after successful submission if needed
            }
        };
        xhr.send(formData);
    }
    