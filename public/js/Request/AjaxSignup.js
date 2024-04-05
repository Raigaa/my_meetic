$(document).ready(function () {
    $(".form__create-account").submit(function (event) {
        event.preventDefault();

        var formData = {
            email: $("#email").val(),
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            phone: $("#tel").val(),
            description: $("#description").val(),
            birthdate: $("#dob").val(),
            location: $("#location").val(),
            password: $("#password").val(),
            gender_id: $("#gender").val(),
            hobbies: getCheckedHobbies() 
        };

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var phonePattern = /^\d{10}$/; 
        var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~]).{8,}$/;
        
        var isValid = true;

        for (var key in formData) {
            if (formData.hasOwnProperty(key)) {
                if (!formData[key]) {
                    isValid = false;
                    alert("Please fill in all fields.");
                    break;
                }

                if (key === 'firstname' || key === 'lastname') {
                    if (formData[key].length < 2) {
                        isValid = false;
                        alert("First name and last name must be at least 2 characters long.");
                        break;
                    }
                }

                if (key === 'description') {
                    if (formData[key].length < 10) {
                        isValid = false;
                        alert("Description must be at least 10 characters long.");
                        break;
                    }
                }
            }
        }

        if (!emailPattern.test(formData.email)) {
            isValid = false;
            alert("Please enter a valid email address.");
        }

        if (!phonePattern.test(formData.phone)) {
            isValid = false;
            alert("Please enter a valid phone number (10 digits).");
        }

        if (!passwordPattern.test(formData.password)) {
            isValid = false;
            alert("The password must contain at least 8 characters, including at least one number, one upper-case letter and one lower-case letter.");
        }

        var birthdate = new Date(formData.birthdate);
        var eighteenYearsAgo = new Date();
        eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);
        var oneHundredFiftyYearsAgo = new Date();
        oneHundredFiftyYearsAgo.setFullYear(oneHundredFiftyYearsAgo.getFullYear() - 150);
        
        if (birthdate > eighteenYearsAgo || birthdate < oneHundredFiftyYearsAgo) {
            isValid = false;
            alert("Your age must be between 18 and 150 to register.");
        }
        

        if (formData.hobbies.length === 0) {
            isValid = false;
            alert("Please select at least one hobby.");
        } else if (formData.hobbies.length > 7) {
            isValid = false;
            alert("Please select a maximum of five hobbies.");
        }

        if (isValid) {

            $.ajax({
                type: "POST",
                url: "../../../controller/Signup.php",
                data: { formData: formData },
                dataType: "json",
                success: function (response) {
                    if (response.redirect) {
                        alert("Redirect to the login page.");
                        window.location.href = "../../../views/Auth/login_view.php";
                    } 
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

    function getCheckedHobbies() {
        var hobbies = [];
        $(".hobbyContainer input[type='checkbox']:checked").each(function() {
            hobbies.push($(this).val());
        });
        return hobbies;
    }
});
