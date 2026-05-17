@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('transaction.transaction_management') }}</h4>
        </div>
        <div class="page-btn">
            <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#manageAreasModal">
                <i class="ti ti-plus fs-16 me-1"></i>{{ __('transaction.add_row') }}
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>{{ __('transaction.date') }}</th>
                        <th>{{ __('transaction.account') }}</th>
                        <th>{{ __('transaction.balance') }}</th>
                        <th>{{ __('transaction.location') }}</th>
                        <th>{{ __('transaction.number') }}</th>
                        <th>{{ __('transaction.description') }}</th>
                        <th class="text-success">{{ __('transaction.credit') }}</th>
                        <th class="text-danger">{{ __('transaction.debit') }}</th>
                        <th class="text-success">{{ __('transaction.toman') }}</th>
                        <th class="text-danger">{{ __('transaction.toman') }}</th>
                        <th class="text-success">{{ __('transaction.dollar') }}</th>
                        <th class="text-danger">{{ __('transaction.dollar') }}</th>
                        <th class="text-success">{{ __('transaction.afg') }}</th>
                        <th class="text-danger">{{ __('transaction.afg') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-1"><input type="date" name="date[]" value="{{ date('Y-m-d') }}" id="date_0"
                                class="form-control p-1 h-100"></td>
                        <td class="p-1"><select name="account[]" id="account_0" class="form-select p-1 h-100">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-1"><input type="number" readonly id="balance_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="text" name="location[]" id="location_0"
                                class="form-control p-1 h-100"></td>
                        <td class="p-1"><input type="text" name="number[]" id="number_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="text" name="description[]" id="description_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="number" step="0.01" name="credit[]" id="credit_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="number" step="0.01" name="debit[]" id="debit_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="number" step="0.01" name="toman_credit[]" id="toman_credit_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="number" step="0.01" name="toman_debit[]" id="toman_debit_0"
                                class="form-control p-1 h-100 text-center">
                        </td>
                        <td class="p-1"><input type="number" step="0.01" name="dollar_credit[]" id="dollar_credit_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="number" step="0.01" name="dollar_debit[]" id="dollar_debit_0"
                                class="form-control p-1 h-100 text-center"></td>
                        <td class="p-1"><input type="number" step="0.01" name="afg_credit[]" id="afg_credit_0"
                                class="form-control p-1 h-100 text-center">
                        </td>
                        <td class="p-1"><input type="number" step="0.01" name="afg_debit[]" id="afg_debit_0"
                                class="form-control p-1 h-100 text-center">
                        </td>
                        <td class="p-1"><a href="javascript:void(0);" class="btn btn-danger btn-sm"><i
                                    class="ti ti-trash"></i></a>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#addBtn').click(function() {
            var index = $('.trRow').length;
            var html = `
            <tr class="trRow" id="trRow_${index}">
                <td><input type="text" class="form-control" id="name_${index}" name="name[]" placeholder="${__('accounts.account_name')}"></td>
                <td>
                    <select class="form-select" id="account_type_${index}" name="account_type[]">
                        <option value="account" selected>${__('accounts.account')}</option>
                        <option value="area">${__('accounts.area')}</option>
                        <option value="user">${__('accounts.user')}</option>
                        <option value="supplier">${__('accounts.supplier')}</option>
                        <option value="customer">${__('accounts.customer')}</option>
                    </select>
                </td>
                <td><select class="form-select" id="account_status_${index}" name="account_status[]">
                        <option value="active" selected>${__('accounts.active')}</option>
                        <option value="inactive">${__('accounts.inactive')}</option>
                    </select></td>
                <td><select class="form-select" id="parent_account_${index}" name="parent_account[]">
                        <option value="">${__('accounts.select_parent')}</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select></td>
                <td>
                    <select class="form-select" id="currency_${index}" name="currency[]">
                        <option value="toman" selected>{{ __('transaction.toman') }}</option>
                        <option value="dollar">{{ __('transaction.dollar') }}</option>
                        <option value="afg">{{ __('transaction.afg') }}</option>
                    </select>
                </td>
                <td>
                    <select class="form-select" id="account_access_${index}" name="account_access[]">
                        <option value="public" selected>${__('accounts.public')}</option>
                        <option value="private">${__('accounts.private')}</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeBtn" data-index="${index}">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            </tr>`;

            $('#accountsTable tbody').append(html);
        });

        $(document).on('click', '.removeBtn', function() {
            var index = $(this).data('index');
            $('#trRow_' + index).remove();
        });
    </script>
@endsection
