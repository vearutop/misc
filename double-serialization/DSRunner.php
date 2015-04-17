<?php

require_once 'BenchmarkRunner.php';

class DSRunner extends BenchmarkRunner
{
    public function init() {
        set_time_limit(0);
        $this->workers = array(
            'php54' => 'php',
            'php56' => '/opt/php-5.6.6/bin/php',
            'php7' => '/opt/php-ng/bin/php',
            'hhvm37' => 'sudo hhvm',
        );
        $this->scripts = array(
            'ds.php',
//	'dj.php',
//	'di.php',
        );

        $this->xAxisArguments = array_merge(range(100, 500, 100), range(700, 3000, 200)/*, range(3500, 50000, 500)*/);
        $this->movingAverageWidth = 12;
    }

    const CHART_SINGLE = 'Single, %';
    const CHART_SPEED_BS = 'Speed, b/s';
    const CHART_SPEED_ES = 'Speed, elements/s';


    public function renderReport()
    {
        //parent::renderReport();
        //return;

        $this->renderReportHead();

        $this->chartIndex = 0;
        foreach ($this->charts as $chartName => $series) {
            $this->renderChart($chartName, $series, true);
        }

///////////////
        $series = $this->charts[self::CHART_SPEED_BS];
        foreach ($series as $seriesName => $seriesData) {
            if (!$this->tails($seriesName, 'single_serialization')
                && !$this->tails($seriesName, 'single_unserialization')) {
                unset($series[$seriesName]);
            }
        }
        $this->renderChart(self::CHART_SPEED_BS, $series, true, 'Single serialization');
/////////////////
        $series = $this->charts[self::CHART_SPEED_ES];
        foreach ($series as $seriesName => $seriesData) {
            if (!$this->tails($seriesName, 'single_serialization')
                && !$this->tails($seriesName, 'single_unserialization')) {
                unset($series[$seriesName]);
            }
        }
        $this->renderChart(self::CHART_SPEED_ES, $series, true);
/////////////
        $series = $this->charts[self::CHART_SINGLE];
        foreach ($series as $seriesName => $seriesData) {
            if (!$this->tails($seriesName, 'double_nested_serialization')) {
                unset($series[$seriesName]);
            }
        }
        $this->renderChart(self::CHART_SINGLE, $series, true, 'Double serialization performance impact');
////////////////
        $series = $this->charts[self::CHART_SINGLE];
        foreach ($series as $seriesName => $seriesData) {
            if (!$this->tails($seriesName, 'double_nested_unserialization')) {
                unset($series[$seriesName]);
            }
        }
        $this->renderChart(self::CHART_SINGLE, $series, true);
/////////////////

        $this->renderReportTail();
        file_put_contents($this->reportFilename, $this->reportHTML);
    }
}

