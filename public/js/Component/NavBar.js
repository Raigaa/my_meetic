document.addEventListener("DOMContentLoaded", function() {
    var navbar = document.createElement('nav');
    navbar.classList.add('navbar');

    var logo = document.createElement('div');
    logo.classList.add('logo');
    logo.textContent = 'My Meetic';
    navbar.appendChild(logo);

    var dropDownMenu = createDropDownMenu();
    navbar.appendChild(dropDownMenu);

    document.body.appendChild(navbar);

    generateDropDownMenuStyles();
});

function createDropDownMenu() {
    var dropDownMenu = document.createElement('div');
    dropDownMenu.id = 'dropDownMenu';
    dropDownMenu.classList.add('dropdown');

    var button = createDropDownButton();
    dropDownMenu.appendChild(button);

    var optionsList = createOptionsList();
    dropDownMenu.appendChild(optionsList);

    button.addEventListener('click', function() {
        optionsList.classList.toggle('show');
    });

    window.addEventListener('click', function(event) {
        if (!event.target.matches('.dropdown-button')) {
            if (optionsList.classList.contains('show')) {
                optionsList.classList.remove('show');
            }
        }
    });

    return dropDownMenu;
}

function createDropDownButton() {
    var button = document.createElement('button');
    button.id = 'dropdownBtn';
    button.classList.add('dropdown-button');
    button.textContent = 'Menu';
    return button;
}

function createOptionsList() {
    var optionsList = document.createElement('div');
    optionsList.id = 'dropdownContent';
    optionsList.classList.add('dropdown-content');

    var options = [
        { text: 'Profile', url: '/views/User/user_view.php' },
        { text: 'Home', url: '/views/User/home_view.php' },
    ];
    options.forEach(function(option) {
        var link = document.createElement('a');
        link.textContent = option.text;
        link.href = option.url;
        link.classList.add('dropdown-link');
        optionsList.appendChild(link);
    });

    return optionsList;
}

function generateDropDownMenuStyles() {
    var style = document.createElement('style');
    style.textContent = `
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            background-color: #333;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .logo {
            color: white;
            font-size: 24px;
        }

        .dropdown-button {
            background-color: #555;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 999; 
            right: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
        }
    `;
    document.head.appendChild(style);
}
