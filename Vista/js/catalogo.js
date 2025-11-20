const stockConfig = {
    in: { text: "En stock", class: "stock-in" },
    low: { text: "Stock bajo", class: "stock-low" },
    out: { text: "Sin stock", class: "stock-out" }
};
let catalogItems = [];

async function fetchProductos() {
    try {
        const response = await fetch('Action/getProductos.php');
        if (!response.ok) throw new Error("Error cargando productos");
        const data = await response.json();

        console.log("Productos recibidos:", data);

        catalogItems = data.map(item => {
            let status = "out";
            const quantity = item.stock?.quantity || 0;
            if (quantity > 5) status = "in";
            else if (quantity > 0) status = "low";

            const imgSrc = item.image && item.image.trim() !== ""
                ? item.image
                : `https://dummyimage.com/300x400/000000/ffffff&text=${encodeURIComponent(item.title)}`;

            return {
                id: item.id,
                title: item.title,
                description: item.description,
                price: item.price,
                image: imgSrc,
                tags: item.tags || [],
                stock: { quantity: quantity, status: status },
                available: item.available
            };
        });

        initCatalog();
    } catch (err) {
        console.error(err);
        alert("Error cargando productos. Revisa la consola.");
    }
}

function createCatalogItem(item) {
    const stockInfo = stockConfig[item.stock.status];
    return `
        <div class="catalog-item" data-id="${item.id}">
            <div class="catalog-stock ${stockInfo.class}">${stockInfo.text}</div>
            <img src="${item.image}" class="item-image" alt="${item.title}">
        </div>
    `;
}

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
            <div class="fullscreen-tags">${item.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}</div>
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
        </div>
    `;
}

function initCatalog() {
    const container = document.getElementById("catalogContainer");
    container.innerHTML = catalogItems.filter(i => i.available).map(createCatalogItem).join('');

    document.querySelectorAll('.catalog-item').forEach(item => {
        item.addEventListener('click', function() {
            const itemId = this.dataset.id;
            const itemData = catalogItems.find(i => i.id == itemId);
            if (!itemData) return;
            const fs = document.getElementById("fullscreenView");
            const content = document.getElementById("fullscreenContent");
            content.innerHTML = createFullscreenContent(itemData);
            fs.classList.add("active");
        });
    });

    document.querySelector('.fullscreen-close-btn').onclick = () => document.getElementById("fullscreenView").classList.remove("active");
    document.getElementById("fullscreenView").onclick = (e) => { if (e.target.id === "fullscreenView") e.currentTarget.classList.remove("active"); };
}

function addToCart(itemId) {
    const item = catalogItems.find(i => i.id == itemId);

    if (item && item.stock.quantity > 0) {

        item.stock.quantity--;
        initCatalog();

        // HTML del PDF
        const htmlPDF = `
            <h1>Gracias por su compra</h1>
            <p>Producto: <strong>${item.title}</strong></p>
            <p>Precio: <strong>$${item.price}</strong></p>
        `;

        // Crear formulario dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../Control/generar_pdf.php';
        form.target = '_blank'; // Abrir en nueva pestaña

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'html';
        input.value = htmlPDF;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        form.remove();

        alert(`¡${item.title} fue comprado con exito!`);

    } else {
        alert(`Lo sentimos, ${item.title} ya no está disponible.`);
    }
}





document.addEventListener("DOMContentLoaded", fetchProductos);
