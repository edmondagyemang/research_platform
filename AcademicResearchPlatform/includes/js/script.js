document.addEventListener('DOMContentLoaded', function () {
    console.log("Script loaded!");

    // Example: Display alert on form submission
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function () {
            alert("Form submitted!");
        });
    });

    // Add more interactivity here as needed
});
