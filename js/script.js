let links = document.querySelectorAll('.image_link');
let image_display = document.querySelector('.image_display');

image_display.onclick = function(e) {
    image_display.close();
}

links.forEach(link => link.onclick = function(e) {
    e.preventDefault();
    image_display.innerHTML = `<img src="${link.href}"/>`;
    image_display.showModal();
});