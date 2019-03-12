
var ctx = document.getElementById('myChart').getContext('2d');
var dataLabel;
var dataTemperature;
var dataHumidity;
var chart = new Chart(ctx, {
    type: 'line',

    data: {
        labels: [5,10,15,5,10,15,5,10],
        // labels: [<?php echo $label; ?>],
datasets: [
{
    label: "Temperatur",
    backgroundColor: 'transparent',
    borderColor: 'rgb(0, 0, 0)',
// data: [<?php echo $temperature; ?>]
data: [ 33.75, 33.75, 33.75, 33.75, 33.75, 33.75, 33.75, 33.75]
},
{
    label: "Luftfeuchtigkeit",
    backgroundColor: 'transparent',
    borderColor: 'rgb(30, 144, 255)',
    // data: [<?php echo $humidity; ?>]
    data: [ 50, 50, 50, 50, 50, 50, 50, 50]
    }]
},

options: {

}


});

function updateChart() {
    console.log(dataTemperature);
    console.log(dataHumidity);
    console.log(dataLabel);

    chart.data.datasets[0].data = dataTemperature;
    chart.data.datasets[1].data = dataHumidity;
    chart.data.labels = dataLabel;
    chart.update();
}


function setLabel(lbl) {
    this.dataLabel = lbl;
}

function setTemperature(temp) {
    this.dataTemperature = temp;
}

function setHumidity(hum) {
    this.dataHumidity = hum;

}

