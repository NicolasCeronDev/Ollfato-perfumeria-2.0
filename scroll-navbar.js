document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.Header');
    const navbar = document.querySelector('.navbar');
    let lastScrollTop = 0;
    let headerHeight = header.offsetHeight;
    let isNavbarFixed = false;
    let initialNavbarLeft = navbar.getBoundingClientRect().left; // Obtener la posición inicial

    window.addEventListener('scroll', () => {
        let scrollTop = window.scrollY || document.documentElement.scrollTop;
        const currentHeaderHeight = header.offsetHeight;

        if (scrollTop > currentHeaderHeight && !isNavbarFixed) {
            // Si hemos pasado el header y el navbar no está fijo, lo fijamos
            navbar.classList.add('fixed');
            navbar.style.left = `${initialNavbarLeft}px`; // Establecer la posición izquierda
            navbar.style.width = `${navbar.offsetWidth}px`; // Establecer el ancho fijo
            isNavbarFixed = true;
        } else if (scrollTop <= currentHeaderHeight && isNavbarFixed) {
            // Si estamos de vuelta dentro del header, removemos la fijación
            navbar.classList.remove('fixed');
            navbar.style.left = ''; // Limpiar la posición izquierda fija
            navbar.style.width = ''; // Limpiar el ancho fijo
            navbar.classList.remove('oculto'); // Aseguramos que esté visible
            navbar.style.transform = 'translateY(0)'; // Reseteamos la transformación
            isNavbarFixed = false;
            initialNavbarLeft = navbar.getBoundingClientRect().left; // Actualizar la posición inicial (por si acaso la ventana cambió de tamaño)
        }

        // Lógica para mostrar/ocultar solo cuando el navbar está fijo
        if (isNavbarFixed) {
            if (scrollTop > lastScrollTop) {
                // Bajando: ocultar el navbar fijo
                if (!navbar.classList.contains('oculto')) {
                    navbar.style.transform = `translateY(-${navbar.offsetHeight}px)`;
                    navbar.classList.add('oculto');
                }
            } else {
                // Subiendo: mostrar el navbar fijo
                if (navbar.classList.contains('oculto')) {
                    navbar.style.transform = 'translateY(0)';
                    navbar.classList.remove('oculto');
                }
            }
        }

        lastScrollTop = scrollTop;
    });

    window.addEventListener('resize', () => {
        headerHeight = header.offsetHeight;
        initialNavbarLeft = navbar.getBoundingClientRect().left; // Actualizar la posición inicial en redimensionamiento
        if (isNavbarFixed) {
            navbar.style.left = `${initialNavbarLeft}px`; // Reajustar la posición fija en redimensionamiento
            navbar.style.width = `${navbar.offsetWidth}px`; // Reajustar el ancho fijo en redimensionamiento
        }
    });
});