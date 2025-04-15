document.querySelectorAll(".accordion-header").forEach(button => {
    button.addEventListener("click", () => {
        const content = button.nextElementSibling;
        button.classList.toggle("active");

        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
});

const dots = document.querlySelectorAll('.dots input');
const slideshow = document.querySelector('.slideshow');

dots.forEach((dot, index) => {
    dot.addEventListener('change', () => {
        slideshow.style.transform = `translateX(-${index * 100}%)`;
    });
});


function toggle(){
    var blur = document.getElementById('fullpage');
    blur.classList.toggle('active'); 

    var popup = document.getElementById('sign-up-popup');
    popup.classList.toggle('active');
}


//---- After login
// function toggleDropdown() {
//     const dropdown = document.getElementById("dropdown-menu");
//     dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
// }

// // Optional: close dropdown if you click outside of it
// window.addEventListener("click", function(e) {
//     const dropdown = document.getElementById("dropdown-menu");
//     const button = document.querySelector(".dropdown-btn");

//     if (!dropdown.contains(e.target) && !button.contains(e.target)) {
//         dropdown.style.display = "none";
//     }
// });

function toggleDropdown() {
    const dropdown = document.getElementById('dropdown-menu');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Close the dropdown if clicked outside
document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdown-menu');
    const button = document.querySelector('.sign-in-btn');

    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});