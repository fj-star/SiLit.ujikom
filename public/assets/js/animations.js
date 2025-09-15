document.addEventListener("DOMContentLoaded", () => {
    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.2
    };

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-visible");
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    const animatedElements = document.querySelectorAll(".fade-in, .fade-in-left, .fade-in-right");
    animatedElements.forEach(element => {
        observer.observe(element);
    });
});