$.ajax({
    url: "../../controller/GetHobbies.php",
    type: 'GET',
    success: function(data) {
        if (Array.isArray(data)) {
            var hobbyContainer = $(".hobbyContainer");

            data.forEach(function(hobby) {
                if (hobby.name) {
                    var hobbyNameWithoutSpaces = hobby.name.replace(/\s/g, '');

                    var container = $("<div>").addClass("checkbox-label-container");

                    var label = $("<label>").text(hobby.name).addClass("hobby-label").attr("for", hobby.id);

                    var checkbox = $("<input>").attr({
                        "type": "checkbox",
                        "value": hobby.id,
                        "class": hobbyNameWithoutSpaces, 
                        "id": hobby.id,
                        "name": hobby.id
                    });

                    container.append(label).append(checkbox);

                    container.css({
                        "display": "flex",
                        "align-items": "center"
                    });
                    label.css("margin-right", "10px");

                    hobbyContainer.append(container);
                }
            });
        } else {
            console.error("The data received is not in array form.");
        }
    },
    error: function(error) {
        console.log("An error occurred when retrieving hobbies:", error);
    }
});
