@extends('layouts.app')
@section('title','ব্যাঙ্ক একাউন্ট')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <a href="{{ route('bank_account.create') }}" class="btn btn-success bg-gradient-success">ব্যাঙ্ক একাউন্ট যুক্ত করুন</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>উপাংশ</th>
                                <th>ব্যাংকের নাম</th>
                                <th>শাখার নাম</th>
                                <th>হিসাব নাম্বার</th>
                                <th>হিসাব কোড</th>
                                <th>বিস্তারিত</th>
                                <th>প্রারম্ভিক স্থিতি</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->upangsho->upangsho_name ?? '' }}</td>
                                    <td>{{ $account->bank->bank_name ?? '' }}</td>
                                    <td>{{ $account->branch->branch_name ?? '' }}</td>
                                    <td>{{ $account->acc_no }}</td>
                                    <td>{{ $account->acc_code }}</td>
                                    <td>{{ $account->acc_details }}</td>
                                    <td>{{ enNumberToBn(number_format($account->open_balance,2)) }}</td>
                                    <td>
                                        @if ($account->status == 1)
                                            <span class="badge badge-success">সক্রিয়</span>
                                        @else
                                            <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                        @endif
                                    </td>
                                    <td>
                                       <a href="{{ route('bank_account.edit',['bankAccount'=>$account->bank_details_id]) }}" class="btn btn-success bg-gradient-success btn-sm btn-edit"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]
                ],
                "dom": 'lBfrtip',
                "buttons": [
                    {
                        "extend": "copy",
                        "text": "<i class='fas fa-copy'></i> Copy",
                        "className": "btn btn-info"
                    }, {
                        "extend": "csv",
                        "text": "<i class='fas fa-file-csv'></i> Export to CSV",
                        "className": "btn btn-warning text-white"
                    },
                    {
                        "extend": "excel",
                        "text": "<i class='fas fa-file-excel'></i> Export to Excel",
                        "className": "btn btn-success"
                    },
                    {
                        "extend": "pdf",
                        "text": "<i class='fas fa-file-pdf'></i> Export to PDF",
                        "className": "btn btn-danger"
                    },
                    {
                        "extend": "print",
                        "text": "<i class='fas fa-print'></i> Print",
                        "className": "btn btn-success bg-gradient-success"
                    }
                ],
                "responsive": true, "autoWidth": false,
            });
        })
    </script>
@endsection
