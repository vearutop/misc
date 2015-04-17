<?php

class BenchmarkRunner
{
    public $workers = array('php' => 'php');
    public $scripts = array();
    public $series = array();
    public $movingAverageWidth = 0;
    public $xAxisArguments = array();
    public $charts = array();
    public $reportFilename = 'report.html';
    public $chartsDataFilename = 'charts.json';

    public function run()
    {

        foreach ($this->xAxisArguments as $argument) {
            foreach ($this->workers as $workerName => $worker) {
                foreach ($this->scripts as $script) {
                    echo "$workerName $script $argument\n";

                    $result = exec($worker . ' ' . $script . ' ' . $argument);

                    $result = json_decode($result, 1);

                    if (!$result) {
                        continue;
                    }

                    foreach ($result as $chartName => $chartSeries) {
                        foreach ($chartSeries as $seriesName => $points) {
                            foreach ($points as $point) {
                                $this->charts [$chartName][$workerName . ':' . $script . ':' . $seriesName] [] = $point;
                            }
                        }
                    }
                }
            }
            $this->saveReport();
        }
        $this->saveReport();
    }


    public function saveReport()
    {
        file_put_contents($this->chartsDataFilename, json_encode($this->charts));
        $this->renderReport();
    }


    protected $chartIndex = 0;
    protected $reportHTML = '';

    protected function renderChart($chartName, $series, $smooth = false, $chartHeading = '')
    {
        ++$this->chartIndex;

        if ($chartHeading) {
            $this->reportHTML .= <<<HTML
            <h2>$chartHeading</h2>
HTML;
        }

        $this->reportHTML .= <<<HTML
<div id="hc-$this->chartIndex"></div>
HTML;
        $hcSeries = array();
        foreach ($series as $serieName => &$values) {
            if ($smooth && $this->movingAverageWidth) {
                $this->smoothMovingAverage($values, $this->movingAverageWidth);
            }
            $hcSeries [] = array('name' => $serieName, 'data' => $values);
        }
        $hcSeries = json_encode($hcSeries);
        $hcSeries = str_replace('{"name":', "\n" . '{"name":', $hcSeries);


        $this->reportHTML .= <<<HTML
<script type="text/javascript">
$(function () {
    $('#hc-$this->chartIndex').highcharts({
        title:false,
        credits:{enabled:false},
        plotOptions:{series:{marker:{enabled:false}}},
        yAxis:{title:{text:"$chartName"}},
        series: $hcSeries
    });
});
</script>
HTML;
    }

    protected function renderReportHead() {
        $this->reportHTML = <<<HTML
<html>
<head>
<title>Report</title>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
</head>
<body>
HTML;
    }

    public function renderReport()
    {
        $this->renderReportHead();

        $this->chartIndex = 0;
        foreach ($this->charts as $chartName => $series) {
            $this->renderChart($chartName, $series, true);
        }

        $this->renderReportTail();
        file_put_contents($this->reportFilename, $this->reportHTML);
    }

    protected function renderReportTail() {
        $this->reportHTML .= <<<HTML
</body>
</html>
HTML;
    }


    public function smoothMovingAverage(&$data, $width = 5)
    {
        for ($i = 0; $i < $width; ++$i) {
            $avg [] = $data[0][1];
        }

        foreach ($data as &$item) {
            array_shift($avg);
            $value = $item[1];
            array_push($avg, $value);
            $item[1] = array_sum($avg) / $width;

        }
    }


    protected function tails($haystack, $needle) {
        return $needle === substr($haystack, -strlen($needle));
    }

}
