let humburger = document.querySelector('.humburger');
let nav = document.querySelector('.nav-bar');


humburger.addEventListener('click', () => {
    if (nav.classList.contains('active')) {
        humburger.innerHTML = '<i class="fas fa-bars"></i>';
        nav.classList.remove('active');
        humburger.classList.remove('active');
        return;
    }
    humburger.innerHTML = '<i class="fas fa-times"></i>';
    nav.classList.toggle('active');
    humburger.classList.toggle('active');
});

// Register.php (for available days)
const days = document.querySelectorAll('input[name="days"]');
    const availableDaysInput = document.querySelector('input[name="available_days"]');
    const availableDays = [];
    days.forEach(day => {
        day.addEventListener('change', () => {
            if (day.checked) {
                availableDays.push(day.value);
                availableDaysInput.value = availableDays.join(',');
            } else {
                availableDays.splice(availableDays.indexOf(day.value), 1);
                availableDaysInput.value = availableDays.join(',');
            }
        });
    });