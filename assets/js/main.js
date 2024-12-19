
//his file will handle the AJAX requests and dynamic loading of the PayTabs iFrame.
// You can also use this file to manage interactions such as submitting forms without reloading the page.


document.addEventListener('DOMContentLoaded', function () {
    const checkoutButton = document.getElementById('checkoutButton');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function () {
            // Perform AJAX request to load PayTabs iframe for payment processing
            const paymentForm = document.getElementById('paymentForm');
            fetch('/includes/checkout.php')
                .then(response => response.text())
                .then(data => {
                    paymentForm.innerHTML = data; // Insert the iframe response
                })
                .catch(error => console.error('Error:', error));
        });
    }
});
