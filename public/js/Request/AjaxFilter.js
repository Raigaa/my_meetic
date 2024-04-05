function getUsersFromDatabase() {
    fetch('/controller/Home.php', {
        method: 'POST' 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des utilisateurs : ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            generateUserCards(data);
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
        });
}

function calculateAge(birthDate) {
    const currentDate = new Date();
    const birthYear = new Date(birthDate).getFullYear();
    const currentYear = currentDate.getFullYear();
    let age = currentYear - birthYear;

    const birthMonth = new Date(birthDate).getMonth();
    const currentMonth = currentDate.getMonth();
    if (currentMonth < birthMonth || (currentMonth === birthMonth && currentDate.getDate() < new Date(birthDate).getDate())) {
        age--;
    }

    return age;
}

function generateUserCards(users) {
    const userList = document.querySelector('.filteredUser');

    userList.innerHTML = '';

    users.forEach(user => {
        const userCard = document.createElement('div');
        userCard.style.border = '1px solid #ccc';
        userCard.style.borderRadius = '5px';
        userCard.style.padding = '10px';
        userCard.style.marginBottom = '10px';
        userCard.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
        userCard.style.backgroundColor = '#fff';
        userCard.style.transition = 'box-shadow 0.3s ease';

        userCard.addEventListener('mouseenter', () => {
            userCard.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });

        userCard.addEventListener('mouseleave', () => {
            userCard.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
        });

        const userName = document.createElement('h2');
        userName.textContent = `${user.firstname} ${user.lastname}`;
        userName.style.fontSize = '18px';
        userName.style.fontWeight = 'bold';
        userCard.appendChild(userName);

        const userEmail = document.createElement('p');
        userEmail.textContent = `Email: ${user.email}`;
        userEmail.style.fontSize = '14px';
        userEmail.style.color = '#333';
        userCard.appendChild(userEmail);

        const userLocation = document.createElement('p'); 
        userLocation.textContent = `Location: ${user.location}`;
        userLocation.style.fontSize = '14px';
        userLocation.style.color = '#333'; 
        userCard.appendChild(userLocation);

        const userDesciption = document.createElement('p');
        userDesciption.textContent = `Description: ${user.description}`;
        userDesciption.style.fontSize = '14px';
        userDesciption.style.color = '#333';
        userCard.appendChild(userDesciption);

        const userAge = document.createElement('p');
        const age = calculateAge(user.birthdate);
        userAge.textContent = `Age: ${age}`;
        userAge.style.fontSize = '14px';
        userAge.style.color = '#333';
        userCard.appendChild(userAge);

        userList.appendChild(userCard);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    getUsersFromDatabase();

    $("#submitBtn").click(function (event) {
        event.preventDefault();

        var hobbyCheckboxes = $("#hobby-selector input[type='checkbox']:checked").map(function () {
            return $(this).val();
        }).get();
        var locationCheckboxes = $("#location-selector input[type='checkbox']:checked").map(function () {
            return $(this).val();
        }).get();
        var selectedGender = $("#gender-selector select").val();
        var ageMinChoosen = $("#minAge").val();
        var ageMaxChoosen = $("#maxAge").val();

        $.ajax({

            type: "POST",
            url: "/controller/Home.php",
            data: {
                hobbies: hobbyCheckboxes,
                locations: locationCheckboxes,
                gender: selectedGender,
                minAge: ageMinChoosen,
                maxAge: ageMaxChoosen
            },
            dataType: "json",
            success: function (response) {
                generateUserCards(response);
                if(response.length === 0) {
                    alert("They are data with this filter.")
                }
            },
            error: function (xhr, status, error) {
                console.error("Erreur :", error);
            }
            
        });
    });
});
