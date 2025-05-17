document.addEventListener("DOMContentLoaded", () => {
  initHeroSwiper();
  initProductSwiper();
  initEspecificProductSwiper();
  initOpinionSwiper();
  handleStickyHeader();
  historyYear();
  historyTransition();
  promoSliderShop();
  filtersAbsolutDrinks();
});

function handleStickyHeader() {
  let lastScrollTop = window.scrollY;
  const header = document.querySelector('header');
  const threshold = 50;

  window.addEventListener('scroll', () => {
    const currentScroll = window.scrollY;

    if (currentScroll < lastScrollTop) {
      header.style.transform = 'translateY(0)';
    }

    if (currentScroll > lastScrollTop && currentScroll > threshold) {
      header.style.transform = 'translateY(-160%)';
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  });
}

/* CARRUSEL */
function initHeroSwiper() {
  new Swiper('.mySwiper', {
    loop: true,
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      el: '.custom-pagination',
      clickable: true,
      renderBullet: function (index, className) {
        return `<span class="${className} custom-bullet"></span>`;
      }
    }
  });
}

function initProductSwiper() {
  new Swiper('.productSwiper', {
  effect: 'coverflow',
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: 'auto',
  loop: true,
  speed: 500,
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 300,
    modifier: 1.5,
    slideShadows: false,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev'
  }
});
}

function initOpinionSwiper() {
  const swiper = new Swiper('.opinionSwiper', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 3,
    loop: true,
    speed: 500,
    coverflowEffect: {
      rotate: 10,
      stretch: 10,
      depth: 160,
      modifier: 1,
      slideShadows: false,
    },
    on: {
      init: function () {
        createCustomPagination(this);
        updateCustomPagination(this.realIndex);
      },
      slideChange: function () {
        updateCustomPagination(this.realIndex);
      },
    }
  });

  function createCustomPagination(swiperInstance) {
    const totalSlides = swiperInstance.wrapperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length;
    const paginationContainer = document.querySelector('.custom-pagination2');
    paginationContainer.innerHTML = '';

    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement('div');
      dot.classList.add('dot');
      dot.addEventListener('click', () => {
        swiperInstance.slideToLoop(i); // use loop index
      });
      paginationContainer.appendChild(dot);
    }
  }

  function updateCustomPagination(activeIndex) {
    const dots = document.querySelectorAll('.custom-pagination2 .dot');
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === activeIndex);
    });
  }
}


function initEspecificProductSwiper() {
  new Swiper('.especificProduct', {
    loop: true,
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      el: '.custom-pagination',
      clickable: true,
      renderBullet: function (index, className) {
        return `<span class="${className} custom-bullet"></span>`;
      }
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });
}

function historyYear() {

  window.addEventListener("DOMContentLoaded", () => {
    const defaultYear = "1979";
    yearTitle.textContent = defaultYear;
    textParagraph.textContent = historiaData[defaultYear];
  });


  const historiaData = {
    "1979": {
      texto: "Absolut nació en Suecia con una idea y misión clara: redefinir el vodka. Desde ese primer destello en 1979, no solo revolucionamos la forma de destilar, sino también la manera de expresarnos. Lo que empezó como una botella icónica y una pequeña fábrica al norte de Suecia, hoy es un símbolo de actitud globalmente reconocido.",
      imagen: "/image/historia/fabrica.jpg"
    },
    "1990": {
      texto: "Outworld adquiere Absolut, marcando un antes y un después en la historia del vodka. Esta unión estratégica convierte a Absolut en el producto insignia del portafolio global de Outworld. A partir de ese momento, la marca inicia una expansión sin precedentes, combinando su herencia sueca con una visión vanguardista del diseño, la cultura y la comunicación.",
      imagen: "/image/historia/fachada.png"
    },
    "2007": {
      texto: "Absolut lanza al mundo una nueva generación de sabores que rompen esquemas y redefinen la categoría del vodka. Inspirados en ingredientes naturales y perfiles sensoriales audaces, nacen variantes icónicas como Mango, Frambuesa y Vainilla. Cada sabor refleja una actitud: libre, creativa y sin límites.",
      imagen: "/image/historia/sabores.png"
    },
    "2024": {
      texto: "Absolut presenta la primera destilería inteligente de su historia, impulsada por inteligencia artificial y energía 100% renovable. Con sede en Åhus, Suecia, este avance marca un hito en la producción de bebidas espirituosas: cada lote es monitoreado en tiempo real, optimizando pureza, sostenibilidad y precisión como nunca antes.",
      imagen: "/image/historia/nueva-fabrica.png"
    },
    "2025": {
      texto: "Medalla de oro y puntuación perfecta 100/100 en el World Vodka Challenge. Absolut by Outworld se posiciona mundialmente como el producto de referencia. Este reconocimiento no solo celebra su excelencia técnica, sino que confirma su impacto cultural y su liderazgo en innovación dentro de la industria.",
      imagen: "/image/historia/WVC_2025.jpg"
    }
  };


  const timelineYears = document.querySelectorAll(".timeline-year");
  const yearTitle = document.getElementById("historia-year");
  const textParagraph = document.getElementById("historia-text");
  const image = document.getElementById("historia-img");


  window.addEventListener("DOMContentLoaded", () => {
    const defaultYear = "1979";
    yearTitle.textContent = defaultYear;
    textParagraph.textContent = historiaData[defaultYear].texto;
    image.src = historiaData[defaultYear].imagen;
  });

  timelineYears.forEach(item => {
    item.addEventListener("click", () => {
      const selectedYear = item.getAttribute("data-year");

      textParagraph.classList.add("fade-out");
      image.classList.add("fade-out");

      setTimeout(() => {
        yearTitle.textContent = selectedYear;
        textParagraph.textContent = historiaData[selectedYear].texto;
        image.src = historiaData[selectedYear].imagen;

        textParagraph.classList.remove("fade-out");
        image.classList.remove("fade-out");
      }, 400);

      timelineYears.forEach(el => el.classList.remove("active-year"));
      item.classList.add("active-year");
    });
  });

}

function historyTransition() {
  document.querySelectorAll('.timeline-cover').forEach(cover => {
    cover.addEventListener('click', () => {
      const content = cover.nextElementSibling;
      cover.style.opacity = '0';
      setTimeout(() => {
        cover.style.display = 'none';
        content.classList.remove('hidden');
        content.classList.add('revealed');
      }, 400);
    });
  });
}

function promoSliderShop() {
  let currentSlide = 0;
  const slides = document.querySelectorAll('.promo-contenido');

  function showNextSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
  }

  setInterval(showNextSlide, 7000);
}

function filtersAbsolutDrinks() {
    // ✅ Objeto para almacenar los filtros seleccionados
    let selectedFilters = {
        'tipo_coctel': null,
        'base_sabor': null,
        'tiempo_preparacion': null
    };

    // Manejar clic en los filtros individuales
    document.querySelectorAll('.filter-sub').forEach(button => {
        button.addEventListener('click', function() {
            // Toggle la clase 'selected' al filtro
            this.classList.toggle('selected');

            // ✅ Mapeamos los filtros seleccionados al objeto
            document.querySelectorAll('.filter-sub.selected').forEach(selectedButton => {
                const category = selectedButton.closest('.filter-dropdown').querySelector('.filter-btn').dataset.category;
                const subcategory = selectedButton.getAttribute('data-subcategory');

                if (category === 'tipo-coctel') {
                    selectedFilters.tipo_coctel = subcategory;
                }
                if (category === 'base-sabor') {
                    selectedFilters.base_sabor = subcategory;
                }
                if (category === 'tiempo-preparacion') {
                    selectedFilters.tiempo_preparacion = subcategory;
                }
            });

            console.log('Filtros seleccionados:', selectedFilters);
        });
    });

    // ✅ Manejar clic en los botones de filtro para mostrar/ocultar los dropdowns
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevenir que el clic se propague y cierre otros dropdowns

            const dropdownContent = this.nextElementSibling; // El menú desplegable es el siguiente elemento (dropdown-content)

            // Verificamos que estamos modificando solo el dropdown-content, no el botón
            if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
                // Alternar la visibilidad del dropdown
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }

                // Revisar si hay algún dropdown visible y agregar/quitar la clase .expanded
                const container = document.querySelector('.search-and-filters');
                const anyOpen = [...document.querySelectorAll('.dropdown-content')].some(dc => dc.style.display === 'block');

                if (anyOpen) {
                    container.classList.add('expanded');
                } else {
                    container.classList.remove('expanded');
                }
            }
        });
    });

    // ✅ Cerrar el menú si se hace clic fuera del dropdown
    window.addEventListener('click', function(event) {
        if (!event.target.closest('.filter-dropdown')) {
            document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                dropdown.style.display = 'none'; // Ocultar todos los dropdowns si se hace clic fuera
            });
        }
    });

    // ✅ Manejar el clic en "Aplicar Filtros"
    document.querySelector('#apply-filters').addEventListener('click', function() {
        let url = new URL(window.location.href);

        // ✅ Limpiar parámetros anteriores
        Object.keys(selectedFilters).forEach(key => {
            url.searchParams.delete(key);
        });

        // ✅ Añadir los nuevos parámetros seleccionados
        Object.keys(selectedFilters).forEach(key => {
            if (selectedFilters[key]) {
                url.searchParams.set(key, selectedFilters[key]);
            }
        });

        // ✅ Redirigir con los filtros seleccionados
        window.location.href = url.toString();
    });

    // ✅ Manejar el clic en "Resetear filtros"
    document.querySelector('#reset-filters').addEventListener('click', function() {
        // Restablecer todos los filtros seleccionados
        document.querySelectorAll('.filter-sub.selected').forEach(subButton => {
            subButton.classList.remove('selected'); // Eliminar la clase 'selected' de todos los filtros
        });

        // ✅ Limpiar los seleccionados del objeto
        selectedFilters = {
            'tipo_coctel': null,
            'base_sabor': null,
            'tiempo_preparacion': null
        };

        console.log('Filtros reseteados.');

        // ✅ Redirigir a la URL limpia
        window.location.href = window.location.pathname;
    });
}












