FusionCharts.ready(function() {
  var distributionChart = new FusionCharts({
    type: 'doughnut2d',
    renderAt: 'chart-container',
    width: '100%',
    height: '450',
    dataFormat: 'json',
    dataSource: {
      "chart": {
        "caption": "Android Version Distribution",
        "subCaption": "2017",
        "theme": "hulk-light",
        "showLabels": "0",
        "showValues": "0",
        "showLegend": "1",
        "legendPosition": "RIGHT",
        "legendBorderAlpha": "60",
        "legendBorderThickness": "0.7",
        "legendShadow": "0",
        "legendBorderColor": "#262626",
        "legendBorderAlpha": "20",
        "defaultCenterLabel": "Android Distribution",
        "centerLabelFontSize": "10",
    //    "centerLabel": "$label",
        "showToolTip": "1",
        "alignCaptionWithCanvas": "0",
        "captionPadding": "0",
        "plottooltext": "<div id='nameDiv'> <b>$label</b><br/><b>Runs on : </b>$percentValue Of devices<br/></div>",
         "centerLabel": "$label: $value",
      },
      "data": [{
        "label": "Ice Cream Sandwich",
        "value": "1000"
      }, {
        "label": "Jelly Bean",
        "value": "5300"
      }, {
        "label": "Kitkat",
        "value": "10500"
      }, {
        "label": "Lollipop",
        "value": "18900"
      }, {
        "label": "Marshmallow",
        "value": "17904"
      }]
    }   