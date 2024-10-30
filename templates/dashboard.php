<?php include 'partials/menu.php'?>
<div class="container">
    <div class="row">
        <div class="col">
            <canvas id="canvas" height="150"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col">
        <?php if (!is_object($data)): ?>
        <div class="alert alert-warning" role="alert">
            No data received from the API. You do not have an active submission or your reports are not ready!
        </div>
        <?php endif;?>
            <?php if (is_object($data)): ?>
            <div class="table-responsive-sm">
                <table class="table">
                    <tr>
                        <td class="bg-light ">Processed URL</td>
                        <td class=""><?php echo $data->service->data->url ?></td>
                        <td class="bg-light ">Last Check</td>
                        <td class=""><?php echo date("d M Y", strtotime(($data->service->data->last_check))) ?></td>
                    </tr>
                    <tr>
                        <td class="bg-light ">Source Name</td>
                        <td class=""><?php echo $data->service->data->map_name ?></td>
                        <td class="bg-light ">Source Type</td>
                        <td class=""><?php echo $data->service->data->map_source ?></td>
                    </tr>
                </table>
            </div>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <div class="col">
        <?php if (is_object($data)): ?>
            <div class="table-responsive-sm">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Status OK</th>
                            <th>Status Error</th>
                            <th>Status Not Found</th>
                            <th>TYPE</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php foreach ($data->reports as $report): ?>
                        <tr>
                            <td><?php echo date("d M Y", strtotime(($report->date))) ?></td>
                            <td><?php echo $report->status_ok ?></td>
                            <td><?php echo $report->status_error ?></td>
                            <td><?php echo $report->status_not_found ?></td>
                            <td>HTTP</td>
                        </tr>
                        <?php endforeach;?>
                       
                    </tbody>
                </table>
            </div>
            <?php endif;?>
            <?php
            $reports = [];
    if (is_object($data)) {
        $reports = array_reverse($data->reports);
    }
?>
        </div>
    </div>
</div>

<script>
$(function() {

    let config = {
        type: 'bar',
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Daily Page Monitoring Report '
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: ''
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Daily Checks'
                    }
                }]
            }
        }
    };

    var ctx = document.getElementById('canvas').getContext('2d');
    window.chart = new Chart(ctx, config);

    <?php foreach ($reports as $report): ?>
    config.data.labels.push('<?php echo $report->date ?>');
    <?php endforeach;?>

    var newDataset = {
        label: 'Status OK',
        backgroundColor: '#58D68D',
        borderColor: '#F0FFFF',
        data: [],
        fill: false
    };

    <?php foreach ($reports as $report): ?>
    newDataset.data.push('<?php echo $report->status_ok ?>');
    <?php endforeach;?>

    config.data.datasets.push(newDataset);
    window.chart.update();

    var newDataset = {
        label: 'Status Not Found',
        backgroundColor: '#c789000',
        borderColor: '#F0FFFF',
        data: [],
        fill: false
    };

    <?php foreach ($reports as $report): ?>
    newDataset.data.push('<?php echo $report->status_not_found ?>');
    <?php endforeach;?>

    config.data.datasets.push(newDataset);
    window.chart.update();

    var newDataset = {
        label: 'Status Error',
        backgroundColor: '#c70000',
        borderColor: '#F0FFFF',
        data: [],
        fill: false
    };

    <?php foreach ($reports as $report): ?>
    newDataset.data.push('<?php echo $report->status_error ?>');
    <?php endforeach;?>

    config.data.datasets.push(newDataset);
    window.chart.update();


});
</script>