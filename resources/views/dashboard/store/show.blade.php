@extends('dashboard.layouts.app')

@section('title_page', 'products')

@section('html')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection

@section('admin_content')

<section style="min-height:fit-content;border-bottom: 5px solid var(--gg);">
    <canvas id="totalUserNow" style="width:100%;max-width:400px;margin: auto;"></canvas>
</section>

<div class="container">
    <div class="row mb-4 justify-content-center">
        <div class="col-12 col-md-6 col-lg-4 m-3">
            <form method="GET" action="{{ route('admin.store.show') }}">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="search" name="search" placeholder="search" class="form-control" value="{{ request('search') }}">
                        <button type="submit" class="input-group-text"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<a href="{{ route('admin.store.add') }}" class="btn btn-dark m-2">Add</a>

<section style="overflow: hidden;overflow-x: auto;">
    <table class="table table-hover table-striped caption-top table-bordered border-dark">
        <thead class="table-active">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name product</th>
                <th scope="col" colspan="2"></th>
            </tr>
        </thead>
        @if($products->count() > 0)
        @foreach ($products as $index => $product)
        <tbody>
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>
                    <p>{{ $product->name_en }}</p>
                </td>


                <td>
                    <a href="{{ route('admin.store.edit', $product->id) }}">
                        <button class="btn btn-info" type="submit" style="margin: 0;">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </a>
                </td>
                </form>

                <td>
                    <form onsubmit="return disableButton()" method="POST" action="{{ route('admin.store.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" type="submit" style="margin: 0;"><i class="bi bi-trash"></i></button>
                    </form>
                </td>


            </tr>
        </tbody>
        @endforeach @else
        <tr>
            <td>No data</td>
        </tr>
        @endif
    </table>

    <div class="d-flex justify-content-center">
        {{$products->links('pagination::bootstrap-4')}}
    </div>

</section>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var xValues = ["products"];
        var yValues = [
            <?= $products->count() ?>,
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
