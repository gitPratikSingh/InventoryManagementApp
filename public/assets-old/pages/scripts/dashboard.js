var Dashboard = function() {

    return {


        initAmChart3: function() {
            if (typeof(AmCharts) === 'undefined' || $('#dashboard_amchart_3').size() === 0) {
                return;
            }

            var chart = AmCharts.makeChart("dashboard_amchart_3", {
              "type": "pie",
              "theme": "light",
              // "labelsEnabled": false,
              // "legend":{
              //  	"position":"right",
              //   "marginRight":100,
              //   "autoMargins":false
              // },
              "dataProvider": equipmentTypes,
              "valueField": "active_eq_count",
              "titleField": "name",
               "balloon":{
               "fixedPosition":true
              },
              "export": {
                "enabled": true
              }
            } );
        },

        initAmChart4: function() {
            if (typeof(AmCharts) === 'undefined' || $('#dashboard_amchart_3').size() === 0) {
                return;
            }

            var chart = AmCharts.makeChart("dashboard_amchart_4", {
              "type": "pie",
              "theme": "light",
              // "labelsEnabled": false,
              // "legend":{
              //  	"position":"right",
              //   "marginRight":100,
              //   "autoMargins":false
              // },
              "dataProvider": equipmentGroups,
              "valueField": "active_eq_count",
              "titleField": "name",
               "balloon":{
               "fixedPosition":true
              },
              "export": {
                "enabled": true
              }
            });
        },


        init: function() {

            // this.initJQVMAP();
            // this.initCalendar();
            // this.initCharts();
            // this.initEasyPieCharts();
            // this.initSparklineCharts();
            // this.initChat();
            // this.initDashboardDaterange();
            // this.initMorisCharts();
            //
            // this.initAmChart1();
            // this.initAmChart2();
            this.initAmChart3();
            this.initAmChart4();

        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Dashboard.init(); // init metronic core componets
    });
}
