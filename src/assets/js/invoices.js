
$(document).ready(function() {
  console.log("Chargement des données statiques pour tester.");
console.log({invoice_details});
  $('#invoice_table').bootstrapTable({
    data: invoice_details, // all_invoices doit être correctement définie par PHP 
    locale: 'fr-FR',
    fixedHeader: false,
  });

  $('#invoice_table').DataTable({
    fixedHeader: false
});
});

function idFormatter() {
  console.log('idFormatter');
  return 'Total'
} 

function priceFormatter(data) {
  var field = this.field;
  console.log({data});
  console.log({field});

  return data.map(function (row) {
    console.log({row});
    // Suppression de ' €' et conversion en nombre
    var price = row[field].replace(' €', '').trim();  // Retirer ' €' et les espaces
    return parseFloat(price); // Convertir en float
  }).reduce(function (sum, i) {
    console.log({sum});
    console.log({i});
    return sum + i; // Additionner les prix
  }, 0) + ' €'; // Ajouter le symbole ' €' à la fin
}


function footerStyle(column) {
  console.log(column);
  return {
    product: {
      css: {display: 'none'}
    },
    product_id: {
      css: {display: 'none'}
    },
    quantity: {
      css: {display: 'none'}
    },
    unit_price: {
      classes: 'uppercase'
    },
    total_product_price: {
      classes: 'total-product-price'
    }
    
  }[column.field];
}
