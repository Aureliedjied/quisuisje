document.addEventListener("DOMContentLoaded", function() {
    const openButton = document.getElementById("openTutorial");
    const modal = document.getElementById("tutorialModal");
    const closeButton = document.getElementById("closeTutorial");

    openButton.addEventListener("click", function() {
        const tutorialPath = openButton.getAttribute("data-tutorial-path");
        // Rediriger vers la page de tutoriel
        window.location.href = tutorialPath;
    });

    closeButton.addEventListener("click", function() {
        modal.classList.add("hidden");
    });
});

