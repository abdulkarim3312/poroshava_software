@extends('layouts.app')
@section('title','বাজেট ব্যবস্থাপন')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-default">
                <div class="card-header">
                    <div class="card-title">বাজেট ব্যবস্থাপন</div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>আর্থ বছর</th>
                                <th>উপাংশ</th>
                                <th>আয়/ব্যায়খাত</th>
                                <th>খাত টাইপ</th>
                                <th>খাত</th>
                                <th>টাকা</th>
                                <th>আয়</th>
                                <th>ব্যায়</th>
                                <th>অবশিষ্ট বাজেট</th>
                                <th>প্রক্রিয়া</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-budget"  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">বাজেট বৃদ্ধি</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="{{ route('budget_update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fiscal_year">আর্থ বছর</label>
                                    <input type="text" readonly id="fiscal_year" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sector_name">খাত</label>
                                    <input type="text" readonly id="sector_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="amount-group">
                                    <input type="hidden" id="budget_id" name="budget_id">
                                    <label for="amount">টাকা <span class="text-danger">*</span></label>
                                    <input type="text"  id="amount" class="form-control" name="amount" placeholder="টাকার পরিমাণ লিখুন">
                                    <span class="help-block"  id="amount-error"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ</button>
                    <button type="submit" id="submitForm" class="btn btn-primary">সংরক্ষণ</button>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('body').on('click', '.budget-edit', function(){
                let budgetId = $(this).data('id');
                $("#budget_id").val(budgetId);
                $("#fiscal_year").val($(this).data('fiscal_year'));
                $("#sector_name").val($(this).data('sector_type_name')+' - '+$(this).data('sector_name'));
                $('#modal-budget').modal('show');
            })
            $('#submitForm').click(function() {
                $.ajax({
                    type: 'POST',
                    url: $('#myForm').attr('action'),
                    data: $('#myForm').serialize(),
                    success: function(response) {
                        // If the form submission is successful
                        // Update the page as desired
                        $('#modal-budget').modal('hide');
                        $(document).Toasts('create', {
                            icon: 'fas fa-envelope fa-lg',
                            class: 'bg-success',
                            title: 'Success',
                            autohide: true,
                            delay: 2000,
                            body: response.success,
                        })
                        location.reload(); // Refresh the page
                    },
                    error: function(xhr) {
                        // If the form submission encounters an error
                        // Display validation errors


                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            // Clear previous error messages
                            $('#amount-group').removeClass('has-error');
                            $('#amount-error').text(' ');
                            // Display new error messages

                            if (errors.amount) {
                                $('#amount-group').addClass('has-error');
                                $('#amount-error').text(errors.amount[0]);
                            }
                        }
                    }
                });
            });

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('budget.datatable') }}',
                columns: [
                    {data: 'year', name: 'year'},
                    {data: 'upangsho_name', name: 'upangsho.upangsho_name'},
                    {data: 'income_expenditure', name: 'income_expenditure'},
                    {data: 'sector_type_name', name: 'taxType.tax_name'},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return data.sector_serilas_name + ' ' + data.sector_name;
                        }
                    },
                    {data: 'budget_amo', name: 'budget_amo'},
                    {data: 'budget_income', name: 'budget_income'},
                    {data: 'budget_expense', name: 'budget_expense'},
                    {data: 'remaining_budget', name: 'remaining_budget'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'desc']],
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
