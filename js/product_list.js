document.addEventListener('DOMContentLoaded', function () {
  const products = [
    {
      image: "",
      label: "New",
      title: "Home Design - Exterior Design - Neo Classic Villa",
      view: "112",
      investor: "Mr. Ravuth",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "1 floor"
    },
    {
      image: "images/pro2.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Modern Villa",
      view: "112",
      investor: "Mr. Vannak",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "2 floors"
    },
    {
      image: "images/pro3.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Contemporary Villa",
      view: "112",
      investor: "Mr. Sopheak",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "3 floors"
    },
    {
      image: "images/pro4.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Luxury Villa",
      view: "112",
      investor: "Mr. Dara",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "2 floors"
    },
    {
      image: "images/pro1.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Neo Classic Villa",
      investor: "Mr. Ravuth",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "1 floor"
    },
    {
      image: "images/pro2.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Modern Villa",
      view: "112",
      investor: "Mr. Vannak",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "2 floors"
    },
    {
      image: "images/pro3.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Contemporary Villa",
      view: "112",
      investor: "Mr. Sopheak",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "3 floors"
    },
    {
      image: "images/pro4.jpg",
      label: "New",
      title: "Home Design - Exterior Design - Luxury Villa",
      view: "",
      investor: "Mr. Dara",
      address: "Phnom Penh",
      area: "200 m²",
      floors: "2 floors"
    }
  ];

  const container = document.getElementById('products-list');
  container.innerHTML = products.map(product => `
        <div class="product-card bg-brand-gray text-white shadow hover:shadow-lg flex flex-col overflow-hidden">
            <div class="relative group cursor-pointer">
              <img src="${product.image || 'images/no_image.jpg'}" alt="${product.title}" class="w-full h-auto transition-opacity duration-300" />
              <span class="absolute top-0 left-0 bg-brand-gold text-brand-white text-xs font-semibold px-3 py-1 rounded-br-lg z-10">${product.label || 'New'}</span>
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <a href="product_detail.php" class="border border-white p-2 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold transition-colors duration-300">
                  <i class="fas fa-link text-white text-xl"></i> 
                </a>
              </div>
            </div>
          <div class="product-info p-4">
            <h3 class="truncate whitespace-nowrap overflow-hidden font-bold text-brand-gold" title="${product.title}">${product.title}</h3>
            <ul  class="mt-2 text-sm text-brand-white">
                <li class="flex items-center gap-2">
                  <i class="fa-solid fa-eye text-brand-gold w-4 h-4"></i>
                  <strong>View:</strong> ${product.view || '--'}
                </li>
                <li class="flex items-center gap-2 mt-1">
                  <i class="fas fa-user text-brand-gold w-4 h-4"></i>
                  <strong>Investor:</strong> ${product.investor || '--'}
                </li>
                <li class="flex items-center gap-2 mt-1">
                  <i class="fas fa-map-marker-alt text-brand-gold w-4 h-4"></i>
                  <strong>Address:</strong> ${product.address || '--'}
                </li>
                <li class="flex items-center gap-2 mt-1">
                  <i class="fas fa-ruler-combined text-brand-gold w-4 h-4"></i>
                  <strong>Area:</strong> ${product.area || '--'}
                </li>
                <li class="flex items-center gap-2 mt-1">
                  <i class="fas fa-layer-group text-brand-gold w-4 h-4"></i>
                  <strong>Number of floors:</strong> ${product.floors || '--'}
                </li>
            </ul>
          </div>
        </div>
      `).join('');
});