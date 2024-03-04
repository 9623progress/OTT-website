function myFunction() {
    var x = document.getElementById("myNavbar");
    console.log(x.className);
    if (x.className === "navbar") {
      x.className += " responsive";
    } else {
      x.className = "navbar";
    }
  }
  // C:\xampp\htdocs\OTT\User\JavaScript\user.js
  // C:\xampp\htdocs\OTT\User\Backend\addToCart.php

  function addToCart(subject, userEmail) {
    // AJAX request to add to cart
    console.log("inside jscart");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./Backend/addToCart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response if needed
            console.log(xhr.responseText)
            alert(xhr.responseText);
        }
    };
    xhr.send("subject=" + subject + "&user_email=" + userEmail);
}



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
  fetch(`./Backend/deleteCart.php?id=${rowId}`, {
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