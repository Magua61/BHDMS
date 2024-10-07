const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");

// open sidebar
menuBtn.addEventListener('click', () =>{
    sideMenu.style.display = 'block';
})

// close sidebar
closeBtn.addEventListener('click', () =>{
    sideMenu.style.display = 'none';
})

// change theme
themeToggler.addEventListener('click', () =>{
    document.body.classList.toggle('dark-theme-variables');

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
})
document.querySelectorAll('.combo-box').forEach(select => {
    select.addEventListener('change', function() {
        const selectedValue = this.value;
        console.log('Selected option:', selectedValue);
        // Handle the option selection logic here
    });
});
// fill table
/* Updates.forEach(update =>{
    const tr = document.createElement('tr');
    const trContent = ' <td>${update.Name}</td><td>${update.Address}</td><td>${update.Age}</td><td>${update.Sex}</td><td>${update.Room}</td><td class="${update.Status === 'Evacuated' ? 'success' : update.Status === 'Departed' ? 'danger' : 'primary'}">${update.Status}</td>';

    tr.innerHTML = trContent;
    document.querySelector('table tbody').appendChild(tr);
}) */

