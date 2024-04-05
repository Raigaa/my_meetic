function getGendersFromDatabase() {
    fetch('/controller/GetUserGender.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur de récupération des données :' + response.status);
            }
            return response.json();
        })
        .then(data => {
            generateGenderSelector(data);
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des genres :', error);
        });
}

function generateGenderSelector(genders) {
    const genderSelector = document.createElement('select');
    genderSelector.name = 'gender';
    genderSelector.style.marginLeft = '3vw';

    genders.forEach(gender => {
        const option = document.createElement('option');
        option.textContent = gender.name;
        option.value = gender.id;
        option.id = gender.id;
        genderSelector.appendChild(option);
    });

    const genderContainer = document.getElementById('gender-selector');
    genderContainer.appendChild(genderSelector);
}
document.addEventListener('DOMContentLoaded', () => {
    getGendersFromDatabase();
});
