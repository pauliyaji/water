
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Production Summary
                </h6>
            </div>
            <div class="card-body">
                <div class="row input-daterange col-md-12">
                    <form method="post" action="reports.prdsearch" class="col-md-12" style="display: flex;">
                        @csrf

                        <div class="col-md-4">
                            <input type="date" name="from_date" @if($fromDate != '01/01/2022') value="{{$fromDate}}" @endif id="from_date" class="form-control" placeholder="From Date" required/>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="to_date" @if($toDate != '01/01/2022') value="{{$toDate}}" @endif id="to_date" class="form-control" placeholder="To Date" required/>
                        </div>
                        <div class="col-md-4 mt-1">
                            <input type="submit" value="Filter" class="btn btn-primary btn-sm" />
                            <a href="{{ route('reports.productsreport') }}"><btn class="btn btn-info btn-sm">Refresh</btn></a>
                        </div>
                    </form>
                    <a href="{{ route('exportproduct') }}" class="btn btn-primary m-2 me-1">Export Data</a>
                    <br/>
                </div>
               @include('excelfiles.product_table')
            </div>
        </div>
        <!-- Modal -->
    </div>
    <!-- /.container-fluid -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

@include('layouts/footer')


<!-- Bootstrap core JavaScript-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total1 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Total over this page
                pageTotal = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(3).footer()).html('₦' + parseFloat(pageTotal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());



            },
        });
    });
</script>
