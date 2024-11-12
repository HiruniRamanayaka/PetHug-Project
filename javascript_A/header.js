//element id pass as parameter
function togglePopup(popupId) {
    const popup = document.getElementById(popupId);
    popup.classList.toggle('active');
}

// when clicking outside of it close popup
window.onclick = function(event) {
    if (!event.target.matches('.fas, button')) {
        const popups = document.querySelectorAll('.popup');
        popups.forEach(popup => {
            popup.classList.remove('active');
        });
    }
}