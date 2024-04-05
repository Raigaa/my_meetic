function createAgeFilterComponent(containerId) {
  const container = document.getElementById(containerId);

  const minAgeInput = document.createElement("input");
  minAgeInput.type = "number";
  minAgeInput.id = "minAge";
  minAgeInput.min = "0";
  minAgeInput.placeholder = "Min Age";

  const maxAgeInput = document.createElement("input");
  maxAgeInput.type = "number";
  maxAgeInput.id = "maxAge";
  maxAgeInput.min = "0";
  maxAgeInput.placeholder = "Max Age";

  container.appendChild(minAgeInput);
  container.appendChild(maxAgeInput);
}

createAgeFilterComponent("age-selector");
