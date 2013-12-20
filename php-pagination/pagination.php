<?php

function pagination($page, $pagesCount, $url) {
    $wing = 3;

    $pageLine = '<span class="paginatorLine">';

    $lwing = $rwing = $wing;

    if ($page - $lwing < 4) {
        $delta = $lwing - $page + 1;
        $rwing += $delta;
        $lwing -= $delta;
    }

    if ($page + $rwing > $pagesCount - 3) {
        $delta = $rwing - $pagesCount + $page;
        $rwing -= $delta;
        $lwing += $delta;
    }


    $low = $page - $lwing;
    $high = $page + $rwing;

    if ($low > 1) {
        $pageLine .= ' <a class="pagerLine" href="' . str_replace('%page%', 1, $url) . '">[1]</a> ';
        $pageLine .= ' … ';
    }

    for ($i = $low; $i < $page; ++$i) {
        $pageLine .= $page > 1 ? ' <a class="pagerLine" href="' . str_replace('%page%', $i, $url) . '">[' . $i . ']</a> ' : '';
    }

    $pageLine .= ' <span class="pagerLine activepage">[*' . $page . ']</span> ';

    for ($i = $page + 1; $i <= $high; ++$i) {
        $pageLine .= ' <a class="pagerLine" href="' . str_replace('%page%', $i, $url) . '">[' . $i . ']</a> ';
    }

    if ($high < $pagesCount) {
        $pageLine .= ' … ';
        $pageLine .= ' <a class="pagerLine" href="' . str_replace('%page%', $pagesCount, $url) . '">[' . $pagesCount . ']</a> ';
    }

    $pageLine .= '</span>';

    return $pageLine;
}

foreach (array_merge(range(1, 10), range(90, 100)) as $page) {
    echo strip_tags(pagination($page, 100, '/%page%')), "\n";
}
