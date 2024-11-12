//pass accordion-header as header parameter
function toggleAccordion(header) {
    const content = header.nextElementSibling;
    
    // Toggle the display property
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        // Hide all other contents
        const allContents = document.querySelectorAll('.accordion-content');
        allContents.forEach(function(item) {
            item.style.display = 'none';
        });
        
        // Show the clicked content
        content.style.display = "block";
    }
}
