$(function () {
  // =====================================
  // Profit
  // =====================================
  (async function () {
    const month = new Date().getMonth() + 1; // Mois actuel
    console.log('Mois actuel :', month);

    try {
        const data = await fetchInvoiceData(month); // Appel à la fonction globale
        console.log('Données récupérées pour le mois :', data);

        // Regrouper les données par jour et par type (facture, devis)
        const dailyData = {};

        data.forEach(item => {
            const day = new Date(item.date_creation).getDate(); // Extraire le jour de la date
            // Initialiser l'objet pour chaque jour si nécessaire
            if (!dailyData[day]) {
                dailyData[day] = { facture: 0, devis: 0 };
            }
            
            // Ajouter le montant de la facture ou du devis
            if (item.type === 'facture') {
                dailyData[day].facture += parseFloat(item.total); // Ajouter montant facture
            } else if (item.type === 'devis') {
                dailyData[day].devis += parseFloat(item.total); // Ajouter montant devis
            }
        });

        // Préparer les catégories (jours du mois) et les séries de données
        const categories = Object.keys(dailyData).sort(); // Trier les jours
        const series = [
            {
                name: 'Montant Factures',
                data: categories.map(day => dailyData[day].facture)
            },
            {
                name: 'Montant Devis',
                data: categories.map(day => dailyData[day].devis)
            }
        ];

        // Options pour le graphique
        const options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: series,
            xaxis: {
                categories: categories,
                title: { text: 'Jour du mois' }
            },
            yaxis: {
                title: { text: 'Montant (€)' }
            },
            title: {
                text: 'Factures et Devis - Par Jour',
                align: 'center'
            }
        };

        // Rendre le graphique
        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
        console.log('Graphique généré avec succès.');
    } catch (error) {
        console.error('Erreur lors du rendu du graphique :', error);
    }
})();

  // =====================================
  // Breakup
  // =====================================
  const breakup = {
      color: "#adb5bd",
      series: [38, 40, 25],
      labels: ["2022", "2021", "2020"],
      chart: {
          width: 180,
          type: "donut",
          fontFamily: "Plus Jakarta Sans', sans-serif",
          foreColor: "#adb0bb",
      },
      plotOptions: {
          pie: {
              startAngle: 0,
              endAngle: 360,
              donut: {
                  size: '75%',
              },
          },
      },
      stroke: {
          show: false,
      },
      dataLabels: {
          enabled: false,
      },
      legend: {
          show: false,
      },
      colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],
      responsive: [
          {
              breakpoint: 991,
              options: {
                  chart: {
                      width: 150,
                  },
              },
          },
      ],
      tooltip: {
          theme: "dark",
          fillSeriesColor: false,
      },
  };

  const breakupChart = new ApexCharts(document.querySelector("#breakup"), breakup);
  breakupChart.render();

  // =====================================
  // Earning
  // =====================================
  const earning = {
      chart: {
          id: "sparkline3",
          type: "area",
          height: 60,
          sparkline: {
              enabled: true,
          },
          group: "sparklines",
          fontFamily: "Plus Jakarta Sans', sans-serif",
          foreColor: "#adb0bb",
      },
      series: [
          {
              name: "Earnings",
              color: "#49BEFF",
              data: [25, 66, 20, 40, 12, 58, 20],
          },
      ],
      stroke: {
          curve: "smooth",
          width: 2,
      },
      fill: {
          colors: ["#f3feff"],
          type: "solid",
          opacity: 0.05,
      },
      markers: {
          size: 0,
      },
      tooltip: {
          theme: "dark",
          fixed: {
              enabled: true,
              position: "right",
          },
          x: {
              show: false,
          },
      },
  };

  new ApexCharts(document.querySelector("#earning"), earning).render();

  $('#invoices_table').bootstrapTable({
    data: all_invoices, // all_invoices doit être correctement définie par PHP 
    locale: 'fr-FR',
  });
  
});

function operateFormatter(value, row, index) {
    console.log({ row });
    return [
      `<a class="view" href="factures/invoice.php?id=${row.invoice_number}" title="Visualiser">`,
      '<i class="fa fa-eye"></i>',
      '</a>  ',
      '    ',
    //   '  <a class="edit" href="" title="edit">',
    //   '<i class="fa fa-pencil-square-o"></i>',
      '</a>'
    ].join('');
}


  window.operateEvents = {
    'click .view': function (e, value, row, index) {
      alert('You click like action, row: ' + JSON.stringify(row))
    },
    'click .remove': function (e, value, row, index) {
      $table.bootstrapTable('remove', {
        field: 'id',
        values: [row.id]
      })
    }
  }