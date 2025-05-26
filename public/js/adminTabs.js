document.addEventListener('DOMContentLoaded', () => {
    const tabBtns = {
        main:      document.getElementById('tab-btn-main'),
        users:     document.getElementById('tab-btn-users'),
        compras:   document.getElementById('tab-btn-compras'),
        productos: document.getElementById('tab-btn-productos'),
        drinks:    document.getElementById('tab-btn-drinks'),
    };
    const tabs = {
        main:      document.getElementById('tab-main'),
        users:     document.getElementById('tab-users'),
        compras:   document.getElementById('tab-compras'),
        productos: document.getElementById('tab-productos'),
        drinks:    document.getElementById('tab-drinks'),
    };

    function activate(name) {
        for (let key in tabBtns) {
            tabBtns[key].classList.toggle('active', key === name);
            tabs[key].classList.toggle('active', key === name);
        }
    }

    tabBtns.main.addEventListener('click',      () => activate('main'));
    tabBtns.users.addEventListener('click',     () => activate('users'));
    tabBtns.compras.addEventListener('click',   () => activate('compras'));
    tabBtns.productos.addEventListener('click', () => activate('productos'));
    tabBtns.drinks.addEventListener('click',    () => activate('drinks'));

    const hash = window.location.hash;
    if (hash === '#tab-users') {
        activate('users');
    } else if (hash === '#tab-compras') {
        activate('compras');
    } else if (hash === '#tab-productos') {
        activate('productos');
    } else if (hash === '#tab-drinks') {
        activate('drinks');
    } else {
        activate('main');
    }
});
