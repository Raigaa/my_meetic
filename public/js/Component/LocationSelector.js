function getLocationsFromDatabase() {
    fetch('/controller/GetUserLocation.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Data recovery error : ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            const uniqueLocations = {};
            const uniqueData = [];
            data.forEach(location => {
                if (!uniqueLocations[location.location]) {
                    uniqueLocations[location.location] = true; 
                    uniqueData.push(location); 
                }
            });
            generateLocationComponents(uniqueData);
        })
        .catch(error => {
            console.error('Error when retrieving rentals :', error);
        });
}

function generateLocationComponents(locations) {
    const locationSelector = document.getElementById('location-selector');
    locationSelector.style.marginLeft = '5vw';

    locations.forEach(location => {
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'locations[]';
        checkbox.value = location.location;

        const label = document.createElement('label');
        label.textContent = location.location;

        const locationContainer = document.createElement('div');
        locationContainer.style.display = 'flex';
        locationContainer.style.alignItems = 'center'; 
        locationContainer.style.marginBottom = '2px'; 
        locationContainer.style.width = '100%';

        checkbox.style.marginRight = '10px';

        locationContainer.appendChild(checkbox);
        locationContainer.appendChild(label);

        locationSelector.appendChild(locationContainer);
    });
}

document.addEventListener('DOMContentLoaded', getLocationsFromDatabase);
