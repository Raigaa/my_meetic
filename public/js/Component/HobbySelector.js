function getHobbiesFromDatabase() {
    fetch('/controller/GetHobbies.php')
        .then(response => response.json())
        .then(data => {
            generateHobbyComponents(data);
        })
        .catch(error => {
            console.error('Error when retrieving hobbies:', error);
        });
}

function generateHobbyComponents(hobbies) {
    const hobbySelector = document.getElementById('hobby-selector');

    hobbies.forEach(hobby => {
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'hobbies[]';
        checkbox.value = hobby.id;

        const label = document.createElement('label');
        label.textContent = hobby.name;

        const hobbyContainer = document.createElement('div');
        hobbyContainer.style.display = 'flex';
        hobbyContainer.style.alignItems = 'center'; 
        hobbyContainer.style.marginBottom = '2px'; 
        hobbyContainer.style.width = '100%';

        checkbox.style.marginRight = '10px';

        hobbyContainer.appendChild(checkbox);
        hobbyContainer.appendChild(label);

        hobbySelector.appendChild(hobbyContainer);
    });
}

document.addEventListener('DOMContentLoaded', getHobbiesFromDatabase);
