  $(document).ready(function(){
  $.ajax({
    url: "https://civicsensesst.altervista.org/stats/stats_pv_questomese.php",
    method: "GET",
    success: function(data) {
      console.log(data);
      var status = [];
      var score = [];

      for(var i in data){
        score.push(data[i]);
      }

      status.push("Totali");


      status.push("Risolti");


      status.push("In attesa di approvazione");


      status.push("Presi in carico");


      status.push("Invalidati");


      status.push("Irrisolti");


      var chartdata = {
        labels: status,
        datasets : [
          {
            label: 'Ticket',
            data: score,
            backgroundColor: [
                            'rgba(255, 183, 227, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 0, 0, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 183, 227,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 0, 0, 1)'
                        ],
             hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
             hoverBorderColor: 'rgba(200, 200, 200, 1)',
             borderWidth: 1
          }
        ]
      };

      var ctx = $("#mycanvas_pv_questomese");
      // var ctx = document.getElementById("mycanvas").getContext('2d');
      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
        options: {
               scales: {
                   yAxes: [{
                       ticks: {
                           beginAtZero:true
                       }
                   }]
               }
           }
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});