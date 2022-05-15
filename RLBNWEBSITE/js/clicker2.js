
    var path = location.pathname; // ex: '/profile';
    var activeItem = document.querySelector("a[href='" + path + "']");
    activeItem.class += 'menu__item--current';
