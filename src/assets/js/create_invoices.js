$(document).ready(function () {
    let productIndex = 1; // Index pour les nouveaux produits
  
    // Fonction pour générer les options des produits
    function generateProductOptions() {
      let options = '<option value="" disabled selected>Choisir un produit</option>';
      productList.forEach(product => {
        options += `<option value="${product.id}">${product.product} (${product.price} €/unité)</option>`;
      });
      return options;
    }
  
    // Ajouter une ligne de produit
    $('#add-product').click(function () {
      const productRow = `
        <div class="product-row mb-3">
          <div class="row">
            <div class="col-md-6">
              <label for="product_${productIndex}" class="form-label">Produit</label>
              <select class="form-select" name="products[${productIndex}][product_id]" id="product_${productIndex}" required>
                ${generateProductOptions()}
              </select>
            </div>
            <div class="col-md-3">
              <label for="quantity_${productIndex}" class="form-label">Quantité</label>
              <input type="number" class="form-control" name="products[${productIndex}][quantity]" id="quantity_${productIndex}" min="1" required>
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-danger mt-4 remove-product">Supprimer</button>
            </div>
          </div>
        </div>
      `;
      $('#products-container').append(productRow);
      productIndex++;
    });
  
    // Supprimer une ligne de produit
    $(document).on('click', '.remove-product', function () {
      $(this).closest('.product-row').remove();
    });
  });
  