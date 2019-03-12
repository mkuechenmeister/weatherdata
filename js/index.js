

$(document).ready(function () {
    $("#btnSearch").click(function () {
        loadFilteredWeatherdata();



    });

    $("#btnClear").click(function () {
        clearInput();



    });

    $('#filter').keypress(function (e) {
        if (e.which == 13) {
            loadFilteredWeatherdata();
        }
    });

    $('html').keyup(function(e){
        if(e.keyCode == 46) {
            clearInput();

        }
    });



});


function clearInput() {
    $("#filter").val("");
    document.getElementById("day").checked = false;
    document.getElementById("month").checked = false;
    document.getElementById("year").checked = false;
    loadAllweatherdata();
}

function parseWeatherdataTable(data) {
    var tmp = "";
    var lbl = [];
    var temp = [];
    var hum = [];

    $.each(data, function (index, weatherdata) {
        tmp += "<tr>";
        tmp += "<td>" + weatherdata.time + "</td>";
        tmp += "<td>" + weatherdata.temperature + "</td>";
        tmp += "<td>" + weatherdata.humidity  + "</td>";
        tmp += "<td>";
        tmp += '<a class="btn btn-info" href="index.php?r=measurement/view&id=' + weatherdata.id+ '"><i data-feather="eye">View</i></a>';
        tmp += '<a class="btn btn-primary" href="index.php?r=measurement/update&id=' + weatherdata.id + '"><i data-feather="edit">Edit</i></a>';
        tmp += '<a class="btn btn-danger" href="index.php?r=measurement/delete&id=' + weatherdata.id + '"><i data-feather="trash">Delete</i></a>';
        tmp += "</td>";
        tmp += "</tr>";

        lbl.push(weatherdata.id);
        temp.push(parseFloat(weatherdata.temperature));
        hum.push(parseFloat(weatherdata.humidity));


    });

    setLabel(lbl);
    setTemperature(temp);
    setHumidity(hum);
    updateChart();
    return tmp;
}

function loadAllweatherdata() {
    $.get("api/measurement/", function (data) {
        $("#weatherdata").html(parseWeatherdataTable(data));
    });
}

function loadFilteredWeatherdata() {
    var filter = $("#filter").val();
    var time = null;

    if (filter == "") {

        loadAllweatherdata();
    }else {




            if (document.getElementById('day').checked) {
                time = filter;

            } else if (document.getElementById('month').checked) {
                var temp = filter.split("-");
                time = temp[0] + "-";
                time += temp[1];
            } else if (document.getElementById('year').checked) {
                var temp = filter.split("-");
                time = temp[0];

            }


        $.get("api/measurement/search/" + time, function (data) {
            $("#weatherdata").html(parseWeatherdataTable(data));
        });
    }

}