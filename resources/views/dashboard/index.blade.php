@extends('dashboard.layouts.app')

@section('html')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection

@section('admin_content')

<section style="min-height:fit-content;border-bottom: 5px solid var(--gg);">
    <canvas id="totalUserNow" style="width:100%;max-width:400px;margin: auto;"></canvas>
</section>

@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {

        var xValues = ["products"];
        var yValues = [
            <?= $storesCount ?>,
        ];
        var barColors = [
            "#b91d47",
        ];

        new Chart("totalUserNow", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "products"
                }
            }
        });
    });
</script>