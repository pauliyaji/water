
@extends('layouts/layout')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Factory Stores Inventory
                    <a href="{{ route("factorystores.create") }}" class="float-right btn btn-success btn-sm">Add New</a>
                </h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead style="background-color: #4e73df; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Raw material</th>
                            <th>Supplier</th>
                            <th>Qty</th>
                            <th>Total price</th>
                            <th>Amount Paid</th>
                            <th>Balance Owed</th>
                            <th>Date of Supply</th>
                            <th>Action</th>

                        </tr>
                        </thead>

                        <tbody>
                            @forelse($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->rawmaterial->name }}</td>
                                    <td>{{ $d->suppliers->name }}</td>
                                    <td>{{ $d->qty }}</td>
                                    <td>{{ number_format($d->total_price, 2) }}</td>
                                    <td>{{ number_format($d->amount_paid, 2)}}</td>
                                    @if($d->balance > 0)
                                    <td style="background-color: #f74646; color: white">{{ number_format($d->balance, 2)}}</td>
                                    @else
                                    <td>{{ number_format($d->balance, 2)}}</td>
                                    @endif
                                    <td>{{ $d->date_of_supply }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('factorystores.show', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('factorystores.edit', $d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                @if(Auth::user()->id == 1)
                                                    <form action="{{ route('factorystores.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                @empty
                                    <tr>
                                        <p>No Available Records</p>
                                    </tr>
                            @endforelse

                        </tbody>
                        <tfoot style="background-color: #023054; color:white;">
                        <tr>

                            <th colspan="4"style="text-align: right;">Total Supply</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="import" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                total0 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    });
                total1 = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                total2 = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                total3 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal0 = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    });
                pageTotal = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                pageTotal2 = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                pageTotal3 = api
                    .column(6, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                // Update footer
                $(api.column(3).footer()).html(pageTotal/10).toString();
                $(api.column(4).footer()).html('₦' + parseFloat(pageTotal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $(api.column(5).footer()).html('₦' + parseFloat(pageTotal2, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $(api.column(6).footer()).html('₦' + parseFloat(pageTotal3, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

            },
        });
    });
</script>
