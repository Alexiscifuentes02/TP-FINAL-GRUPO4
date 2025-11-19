<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ESTILOS GENERALES DE LA BARRA DE NAVEGACIÓN */
        .nav-link {
            padding-left: 10px;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .dropdown-menu {
            min-width: 300px;
            padding: 20px;
        }
        .dropdown-toggle::after {
            margin-left: 5px;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25);
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* ESTILOS DEL SISTEMA DE CATÁLOGO */
        .catalog-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .catalog-item {
            position: relative;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            aspect-ratio: 4/5;
            cursor: pointer;
        }
        .catalog-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .item-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-details { 
            display: none; 
        }

        /* ESTILOS DE INDICADORES DE STOCK */
        .catalog-stock {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .stock-in {
            background-color: #d4edda;
            color: #155724;
        }
        .stock-low {
            background-color: #fff3cd;
            color: #856404;
        }
        .stock-out {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* ESTILOS PARA VISTA DE PANTALLA COMPLETA */
        .fullscreen-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.75);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .fullscreen-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .fullscreen-item {
            position: relative;
            width: 90%;
            max-width: 1200px;
            height: 90%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            transform: scale(0.85);
            transition: transform 0.3s ease;
            box-shadow: 0 0 20px rgba(255,255,255,0.3);
        }
        .fullscreen-overlay.active .fullscreen-item {
            transform: scale(1);
        }

        .fullscreen-close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 45px;
            color: white;
            cursor: pointer;
            z-index: 9999;
            transition: color 0.2s ease;
            text-shadow: 4px 4px #212529 ;
        }
        .fullscreen-close-btn:hover {
            color: #ff6b6b;
        }

        .fullscreen-image-container {
            flex: 0 0 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .fullscreen-image {
            width: 100%;
            height: 100%;
            object-fit: fill;
            max-height: 100%;
            border-radius: 10px;
        }

        .fullscreen-content {
            flex: 1;
            padding: 3rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .fullscreen-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
        }

        .fullscreen-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #212529;
        }

        .fullscreen-description {
            font-size: 1.1rem;
            color: #6c757d;
            line-height: 1.5;
        }

        .fullscreen-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag {
            background-color: #e9ecef;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #495057;
        }

        .fullscreen-price {
            font-size: 2rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .fullscreen-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-add-cart {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-add-cart:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
        .btn-add-cart:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .stock-indicator {
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .stock-in {
            background-color: #d4edda;
            color: #155724;
        }
        .stock-low {
            background-color: #fff3cd;
            color: #856404;
        }
        .stock-out {
            background-color: #f8d7da;
            color: #721c24;
        }

        .stock-quantity {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .fullscreen-details {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .fullscreen-details h3 {
            margin-bottom: 1rem;
            color: #495057;
        }

        .fullscreen-details p {
            color: #6c757d;
            line-height: 1.6;
        }

        /* DISEÑO RESPONSIVE */
        @media (max-width: 768px) {
            .fullscreen-item {
                flex-direction: column;
                width: 95%;
                height: 95%;
                overflow-y: scroll;
            }
            
            .fullscreen-image-container {
                flex: 0 0 40%;
                padding: 1rem;
            }
            
            .fullscreen-content {
                padding: 2rem;
                gap: 1rem;
                overflow-y: visible;
            }
            
            .fullscreen-title {
                font-size: 1.5rem;
            }
            
            .fullscreen-price {
                font-size: 1.5rem;
            }
        }
    </style>
  </head>

  <body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- BARRA DE NAVEGACIÓN PRINCIPAL -->
    <nav class="navbar sticky-top navbar-dark bg-dark px-3">
      <ul class="navbar-nav d-flex flex-row me-auto">
        <li class="nav-item active"><a class="nav-link" href="#">Tienda</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#">Inventario</a></li>
      </ul>

      <div class="d-flex flex-row align-items-center">
        <form class="d-flex me-3">
          <input class="form-control me-2" type="search" placeholder="Búsqueda">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>

        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Iniciar sesión
          </button>

          <div class="dropdown-menu dropdown-menu-end p-3">
            <form>
              <label class="form-label">Usuario</label>
              <input type="text" class="form-control mb-3">
              <label class="form-label">Contraseña</label>
              <input type="password" class="form-control mb-3">
              <button class="btn btn-primary w-100" type="submit">Iniciar sesión</button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- SECCIÓN PRINCIPAL DEL CATÁLOGO -->
    <div class="container my-4">
        <h2 class="mb-4">Catálogo</h2>
        <div class="catalog-container" id="catalogContainer"></div>
    </div>

    <!-- MODAL DE PANTALLA COMPLETA PARA DETALLES -->
    <div id="fullscreenView" class="fullscreen-overlay">
        <span class="fullscreen-close-btn">&times;</span>
        <div id="fullscreenContent" class="fullscreen-item"></div>
    </div>

    <script>
        // OBJETOS DEL CATÁLOGO - Base de datos de productos
        const catalogItems = [
            { 
                id: 1, 
                title: "Horizon Zero Dawn", 
                description: "Un épico juego de rol de acción ambientado en un mundo postapocalíptico donde la naturaleza ha reclamado las ruinas de una civilización avanzada.", 
                image: "https://juegosdigitalesargentina.com/files/images/productos/1570563349-horizon-zero-dawn-complete-edition-ps4.jpg",
                tags: ["Acción", "Exploración", "Supervivencia", "Mundo Abierto"], 
                price: 86000,
                stock: {
                    quantity: 15,
                    status: "in"
                },
                available: true
            },
            { 
                id: 2, 
                title: "Red Dead Redemption 2", 
                description: "Vive la épica historia de Arthur Morgan y la banda de Van der Linde mientras huyen por América en el ocaso de la era del salvaje oeste.", 
                image: "https://images.pushsquare.com/3729796ed72b4/red-dead-redemption-2-ps4-playstation-4-1.900x.jpg",
                tags: ["Acción", "Exploración", "Rockstar", "Western"], 
                price: 99999.99,
                stock: {
                    quantity: 3,
                    status: "low"
                },
                available: true
            },
            { 
                id: 3, 
                title: "Hollow Knight: Silksong", 
                description: "Embárcate en una aventura épica como Hornet, la princesa protectora de Hallownest, en este esperado seguimiento del aclamado Hollow Knight.", 
                image: "https://storegamesargentina.com/wp-content/uploads/2025/09/HOLLOW-KNIGHT-SILKSONG-PS4-150x187.webp",
                tags: ["Metroidvania", "Roguelike", "Git Gud", "Plataformas"], 
                price: 89999.99,
                stock: {
                    quantity: 0,
                    status: "out"
                },
                available: false
            },
            { 
                id: 4, 
                title: "Forza Horizon 5", 
                description: "Explora los vibrantes paisajes de México en el festival Horizon definitivo con cientos de los mejores coches del mundo.", 
                image: "https://cdn1.spong.com/pack/f/o/forzahoriz435771l/_-Forza-Horizon-3-Xbox-One-_.jpg",
                tags: ["Autos", "Carreras", "Mundo Abierto", "Simulación"], 
                price: 129.99,
                stock: {
                    quantity: 8,
                    status: "in"
                },
                available: true
            },
            { 
                id: 5, 
                title: "PES 2020", 
                description: "Experimenta el fútbol más realista con gráficos mejorados, jugabilidad refinada y modos de juego innovadores.", 
                image: "https://img.konami.com/kde_cms/na_publish/uploads/ps4_2d_pes2020_standard-esrb-1024x1293.png",
                tags: ["Fútbol", "Deportes", "Multijugador", "Competitivo"], 
                price: 79.99,
                stock: {
                    quantity: 1,
                    status: "low"
                },
                available: true
            },
            { 
                id: 6, 
                title: "The Idolm@ster Platinum Stars", 
                description: "Conviértete en productor y entrena a tus idols para alcanzar el estrellato en este simulador de ritmo y gestión.", 
                image: "https://upload.wikimedia.org/wikipedia/en/1/1b/Idolmaster_platinum_stars_cover_art.jpg",
                tags: ["Idols", "Anime", "Música", "Simulación"], 
                price: 10000,
                stock: {
                    quantity: 25,
                    status: "in"
                },
                available: false
            }
        ];

        // CONFIGURACIÓN DEL SISTEMA DE STOCK
        const stockConfig = {
            in: {
                text: "En stock",
                class: "stock-in",
                threshold: 5
            },
            low: {
                text: "Stock bajo",
                class: "stock-low",
                threshold: 1
            },
            out: {
                text: "Sin stock",
                class: "stock-out",
                threshold: 0
            }
        };

        // FUNCIÓN: Calcular estado del stock basado en cantidad
        function calculateStockStatus(quantity) {
            if (quantity >= stockConfig.in.threshold) return "in";
            if (quantity >= stockConfig.low.threshold) return "low";
            return "out";
        }

        // FUNCIÓN: Actualizar estados de stock para todos los items
        function updateStockStatuses() {
            catalogItems.forEach(item => {
                item.stock.status = calculateStockStatus(item.stock.quantity);
            });
        }

        // INICIALIZAR estados de stock
        updateStockStatuses();

        // FUNCIÓN: Crear elemento HTML para item del catálogo
        function createCatalogItem(item) {
            const stockInfo = stockConfig[item.stock.status];
            
            return `
                <div class="catalog-item" data-id="${item.id}">
                    <div class="catalog-stock ${stockInfo.class}">
                        ${stockInfo.text}
                    </div>
                    <img src="${item.image}" class="item-image" alt="${item.title}">
                    <div class="item-details">
                        <h3 class="item-title">${item.title}</h3>
                        <p>${item.description}</p>
                        <div>${item.tags.map(t => `<span class='tag'>${t}</span>`).join('')}</div>
                        <div class="d-flex justify-content-between mt-3">
                            <span class="fw-bold text-primary">$${item.price.toLocaleString()}</span>
                            <button class="btn-add-cart" ${item.stock.status === 'out' ? 'disabled' : ''}>
                                ${item.stock.status === 'out' ? 'Sin stock' : 'Agregar al carrito'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // FUNCIÓN: Crear contenido para vista de pantalla completa
        function createFullscreenContent(item) {
            const stockInfo = stockConfig[item.stock.status];
            const isOutOfStock = item.stock.status === 'out';
            
            return `
                <div class="fullscreen-image-container">
                    <img src="${item.image}" class="fullscreen-image" alt="${item.title}">
                </div>
                <div class="fullscreen-content">
                    <div class="fullscreen-header">
                        <h1 class="fullscreen-title">${item.title}</h1>
                        <p class="fullscreen-description">${item.description}</p>
                    </div>
                    
                    <div class="fullscreen-tags">
                        ${item.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}
                    </div>
                    
                    <div class="fullscreen-price">$${item.price.toLocaleString()}</div>
                    
                    <div class="fullscreen-actions">
                        <button class="btn-add-cart" ${isOutOfStock ? 'disabled' : ''} onclick="${isOutOfStock ? '' : `addToCart(${item.id})`}">
                            ${isOutOfStock ? 'Sin stock' : 'Agregar al carrito'}
                        </button>
                        <div>
                            <div class="stock-indicator ${stockInfo.class}">${stockInfo.text}</div>
                            <div class="stock-quantity">${item.stock.quantity} unidades disponibles</div>
                        </div>
                    </div>
                    
                    <div class="fullscreen-details">
                        <h3>Detalles del producto</h3>
                        <p>Disfruta de horas de diversión con este título aclamado por la crítica. Incluye todos los contenidos adicionales y actualizaciones. Compatible con logros/trofeos y modo multijugador en línea (cuando está disponible).</p>
                        ${isOutOfStock ? '<p class="text-danger"><strong>Actualmente sin stock. Esperamos tener más unidades pronto.</strong></p>' : ''}
                    </div>
                </div>
            `;
        }

        // FUNCIÓN PRINCIPAL: Inicializar el catálogo
        function initCatalog() {
            const container = document.getElementById("catalogContainer");
            
            // Filtrar solo juegos disponibles
            const availableItems = catalogItems.filter(item => item.available);
            
            container.innerHTML = availableItems.map(item => createCatalogItem(item)).join('');

            document.querySelectorAll('.catalog-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Prevenir pantalla completa al hacer clic en botón agregar-carrito
                    if (e.target.closest('.btn-add-cart') && !e.target.closest('.btn-add-cart').disabled) {
                        e.stopPropagation();
                        const itemId = this.dataset.id;
                        addToCart(itemId);
                        return;
                    }

                    const itemId = this.dataset.id;
                    // Buscar en el array completo de catalogItems para los datos
                    const itemData = catalogItems.find(i => i.id == itemId);
                    
                    if (!itemData) return;

                    const fs = document.getElementById("fullscreenView");
                    const content = document.getElementById("fullscreenContent");
                    
                    content.innerHTML = createFullscreenContent(itemData);
                    fs.classList.add("active");
                });
            });

            // Manejadores de cierre
            document.querySelector('.fullscreen-close-btn').onclick = () => {
                document.getElementById("fullscreenView").classList.remove("active");
            };

            document.getElementById("fullscreenView").onclick = (e) => {
                if (e.target.id === "fullscreenView") {
                    e.currentTarget.classList.remove("active");
                }
            };
        }

        // FUNCIÓN SIMULADA: Agregar producto al carrito
        function addToCart(itemId) {
            const item = catalogItems.find(i => i.id == itemId);
            if (item) {
                if (item.stock.quantity > 0) {
                    item.stock.quantity--;
                    updateStockStatuses();
                    
                    // Actualizar la UI - solo renderizar items disponibles
                    initCatalog();
                    
                    alert(`¡${item.title} agregado al carrito!`);
                } else {
                    alert(`Lo sentimos, ${item.title} ya no está disponible.`);
                }
            }
        }

        // INICIALIZAR la aplicación cuando el DOM esté listo
        document.addEventListener("DOMContentLoaded", initCatalog);
    </script>

    <!-- ESPACIO DE PRUEBA PARA SCROLL -->
    <div style="height:2000px; background: linear-gradient(to bottom, #f8f9fa, #e9ecef);"></div>

  </body>
</html>