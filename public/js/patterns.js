const patterns_parent = document.getElementById("patternsParent");
fetch("https://127.0.0.1:8000/patterns/patterns-json", {
  method: "GET",
  headers: { "Content-type": "application/json" },
})
  .then((response) => response.json())
  .then((patterns) => {
    console.log(patterns);
    let patternDetail = patterns.map(
      (pattern) =>
        `<div>
            <h2>${pattern.name}</h2>
            <p>${pattern.description}</p>
            <p>Prix : ${pattern.price} €</p>
        </div>`
    );
    patterns_parent.innerHTML = patternDetail.join(" ");
  })
  .catch((error) => console.log(error));
