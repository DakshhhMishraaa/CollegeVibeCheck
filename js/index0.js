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