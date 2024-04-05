<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../../public/style/home.css">
</head>

<body>
    <div id="navbar"></div>

    <form method="POST" class="filter__user" id="home-filter">
        <div class="Filter-Element">
            <div id="hobby-selector"></div>
            <div id="location-selector"></div>
            <div id="gender-selector"></div>
            <div id="age-selector"></div>
        </div>
        <input type="submit" value="Submit" id="submitBtn">
    </form>

    <div>
        <h2>Filtered Data</h2>
        <div class="filteredUser"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../public/js/Component/HobbySelector.js"></script>
    <script src="../../public/js/Component/LocationSelector.js"></script>
    <script src="../../public/js/Component/GenderSelector.js"></script>
    <script src="../../public/js/Component/ageSelector.js"></script>
    <script src="../../public/js/Request/AjaxFilter.js"></script>
    <script src="../../public/js/Component/NavBar.js"></script>
</body>

</html>