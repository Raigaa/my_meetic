$(document).ready(function () {

  function getGender(id) {
      switch (id) {
          case 1:
              return "Male";
          case 2:
              return "Female";
          case 3:
              return "Non binary";
          case 4:
              return "Other";
          default:
              return "No value for gender_id";
      }
  }

  var form = $("form");
  var formElements = form.find("input, select, textarea").not(':input[type="submit"]');
  var originalFormValues = {};
  var formModifiedObject = Object.assign({}, user);
  var passwordField = form.find('input[name="password"]');

  formElements.each(function () {
      var element = $(this);
      var fieldName = element.attr("name");
      if (fieldName !== "password") {
          originalFormValues[fieldName] = element.val();
      }
  });

  formElements.each(function () {
      var element = $(this);
      var fieldName = element.attr("name");
      if (fieldName !== "password") {
          var fieldValue = user[fieldName];
          if (fieldName === "gender_id") {
              fieldValue = parseInt(fieldValue);
              element.val(fieldValue);
              if (fieldValue && fieldValue !== 0) {
                  var genderText = getGender(fieldValue);
              }
              element.change(function () {
                  var selectedGenderId = parseInt($(this).val());
                  formModifiedObject[fieldName] = selectedGenderId;
              });
          } else if (element.attr("type") === "checkbox") {
              element.change(function () {
                  var checkboxId = parseInt($(this).val());
                  if ($(this).is(":checked")) {
                      formModifiedObject[fieldName] = checkboxId;
                  } else {
                      delete formModifiedObject[fieldName];
                  }

                  $.ajax({
                      url: "../../controller/UpdateUserHobbies.php",
                      method: "POST",
                      data: { user_id: user.id, hobbyId: checkboxId, isChecked: $(this).is(":checked") },
                      success: function (response) {
                      },
                      error: function (xhr, status, error) {
                          console.error("Error updating hobbies :", error);
                      }
                  });
              });
          } else {
              element.val(fieldValue || "");
              element.on("input", function () {
                  formModifiedObject[fieldName] = $(this).val();
              });
          }
      } else {
          element.on("input", function () {
              formModifiedObject[fieldName] = $(this).val();
          });
      }
  });

  $(".logout-button").click(function (event) {
      event.preventDefault();
      $.ajax({
          url: "../../controller/Profile.php",
          method: "POST",
          data: { delete_session: true },
          success: function (response) {
              window.location.href = "../../views/Auth/login_view.php";
          },
          error: function (xhr, status, error) {
              console.error("Disconnection error :", error);
          },
      });
  });

  $(".deactivate-button").click(function (event) {
    event.preventDefault();
    $.ajax({
        url: "../../controller/Profile.php",
        method: "POST",
        data: { deactivate_account: true },
        success: function (response) {
            alert("Vous avez désactiver votre compte")
            window.location.href = "../../views/Auth/login_view.php";
        },
        error: function (xhr, status, error) {
            console.error("Account deactivation error :", error);
        },
    });
});

  $.ajax({
      url: "../../../controller/GetUserHobbies.php",
      type: 'GET',
      success: function (data) {
          if (Array.isArray(data)) {
              var hobbyContainer = $(".hobbyContainer");

              data.forEach(function (hobby) {
                  var checkbox = hobbyContainer.find('.' + hobby.name);
                  checkbox.prop("checked", true);
              });
          } else {
              console.log("The data received is not in array form.");
          }
      },
      error: function (error) {
          console.log("An error occurred while retrieving the user's hobbies:", error);
      }
  });

  form.submit(function (event) {
      event.preventDefault();

      var target = $(event.target);

      var checkedCheckboxes = {};

      form.find('input[type="checkbox"]').each(function () {
          var checkbox = $(this);
          var fieldName = checkbox.attr("name");
          if (checkbox.is(":checked")) {
              checkedCheckboxes[fieldName] = checkbox.val();
          }
      });

      var passwordValue = passwordField.val();

      formModifiedObject["password"] = passwordValue;
      
      var formData = {
          user_id: user.id,
          formModifiedObject: formModifiedObject,
          checkedCheckboxes: checkedCheckboxes,
      };

      $.ajax({
          url: "../../../controller/UpdateProfile.php",
          method: "POST",
          data: formData,
          success: function (response) {
          },
          error: function (xhr, status, error) {
              console.error("Query error:", error);
          },
      });

      $.ajax({
          url: "../../../controller/UpdateUserHobbies.php",
          method: "POST",
          data: formData,
          success: function (response) {
          },
          error: function (xhr, status, error) {
              console.error("Query error:", error);
          },
      });
  });
});
