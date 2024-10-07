document.addEventListener("DOMContentLoaded", function () {
    // Sign In Form Validation
    const signInForm = document.querySelector("#login-sn form");
    if (signInForm) {
      signInForm.addEventListener("submit", function (event) {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
  
        if (!validateUsername(username) || !validatePassword(password)) {
          event.preventDefault(); // Prevent form submission if validation fails
          alert("Please provide a valid username and password.");
        }
      });
    }
  
    // Contact Form Validation
    const contactForm = document.querySelector("#contact-sn form");
    if (contactForm) {
      contactForm.addEventListener("submit", function (event) {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const message = document.getElementById("message").value;
  
        if (!validateName(name) || !validateEmail(email) || !validateMessage(message)) {
          event.preventDefault(); // Prevent form submission if validation fails
          alert("Please fill out all fields correctly.");
        }
      });
    }
  
    // Helper validation functions
    function validateUsername(username) {
      return username.trim() !== ""; // Ensure username is not empty
    }
  
    function validatePassword(password) {
      // Ensure password is at least 6 characters
      return password.length >= 6;
    }
  
    function validateName(name) {
      return name.trim() !== ""; // Ensure name is not empty
    }
  
    function validateEmail(email) {
      // Simple email format validation
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
    }
  
    function validateMessage(message) {
      return message.trim() !== ""; // Ensure message is not empty
    }
  });
  