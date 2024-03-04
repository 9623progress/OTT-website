document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM content loaded');
    // Declare a global variable to store the current video ID
    var currentsubjectid;

    document.querySelectorAll('.stars span').forEach(function(starsContainer) {
        
        starsContainer.addEventListener('click', function(event) {
            if (!isLoggedIn) {
                alert('Please log in to give a rating.');
                return;
            }
            handleStarClick(event);
           
        });

        starsContainer.addEventListener('mouseover', function(event) {
            handleStarHover(event);
        });

        starsContainer.addEventListener('mouseout', function() {
            handleStarReset();
        });
    });

    function submitRating(rating, subjectid) {
        alert('You gave a rating of ' + rating + ' out of 5 stars!');

        // Set the rating value in the hidden input field
        document.querySelector('.ratingInput').value = rating;

        // Set the subjectid value in the hidden input field
        document.querySelector('.subjectIdInput').value = subjectid;

        // Submit the form
        document.querySelector('.ratingForm').submit();
    }

    function handleStarClick(event) {
        var clickedStar = event.target;
        var starsContainer = clickedStar.closest('.stars');
        var subjectid = starsContainer.getAttribute('data-subject-id');
        var rating = clickedStar.getAttribute('data-rating');

        currentsubjectid = subjectid;

        starsContainer.querySelectorAll('span').forEach(function(star) {
            star.classList.remove('clicked');
        });

        while (clickedStar) {
            clickedStar.classList.add('clicked');
            clickedStar = clickedStar.previousElementSibling;
        }

        submitRating(rating, subjectid);
    }

    function handleStarHover(event) {
        console.log("inside hovered");
        var hoveredStar = event.target;

        while (hoveredStar) {
            hoveredStar.classList.add('hovered');
            hoveredStar = hoveredStar.previousElementSibling;
        }
    }

    function handleStarReset() {
        console.log("inside not hovered");
        document.querySelectorAll('.stars span').forEach(function(star) {
            star.classList.remove('hovered');
        });
    }
});
