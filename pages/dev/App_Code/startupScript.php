
var chartDom = document.getElementById('3dchart');
var myChart = echarts.init(chartDom);
var option; 

var phpToken = <?php echo json_encode($_SESSION['id']);?>;
var xhr = new XMLHttpRequest();
var tokenBody = {
    data: {
        token: phpToken
    }
};

var jsonData = JSON.stringify(tokenBody);

var xhrLL = new XMLHttpRequest();
xhrLL.open("POST", "https://rela.sdnord.de/rela-rest-ws-test/windydog/<?php if(isset($_SESSION['database'])){echo $_SESSION['database'];}else if(isset($_SESSION['name'])){$string = $_SESSION['name']; $new_string = substr($string, strpos($string, "|") + 1); echo $new_string;}?>/2022/3dchart/", true);
xhrLL.setRequestHeader('Content-Type', 'application/json');
xhrLL.onload = function () {
    if (xhrLL.readyState === xhrLL.DONE) {
        if(xhrLL.status === 200) {
        var Response = JSON.parse(xhrLL.responseText);
        var json = Response.data.chart;
        var dataMapping = {
            x: 'x',
            y: "y",
            z: 'z'
        };
        var xData = json.map(function (item) {
            return item[dataMapping.x];
        });
        var yData = json.map(function (item) {
            return item[dataMapping.y];
        });
        var zData = json.map(function (item) {
             return item[dataMapping.z];
         });

        console.log(xData);
        var barData = json.map(function (item) {
            return [item[dataMapping.x], item[dataMapping.y], item[dataMapping.z]];
        });
        var option = {
            xAxis3D: {type: 'category', data: xData},
            yAxis3D: {type: 'value', data: yData},
            zAxis3D: {type: 'category', data: zData},
            grid3D: {boxWidth: 200, boxDepth: 80, viewControl: {distance: 200}},
            series: [
                {
                    type: 'bar3D',
                    data: barData,
                    shading: 'lambert', // Add some shading to the bars for depth perception
                    label: {
                        show: true,
                        textStyle: {
                            fontSize : 16,
                            borderThickness: 1
                        }
                    },
                    itemStyle: {
                        opacity: 0.8
                    }
                }
            ]
        };
        myChart.setOption(option);
    }
    }
};
xhrLL.send(jsonData);


