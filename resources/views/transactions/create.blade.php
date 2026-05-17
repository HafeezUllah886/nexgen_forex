@extends('layout.window')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h4>{{ __('transaction.transaction_management') }}</h4>
        </div>
        <div class="page-btn">
            <button type="button" class="btn btn-added" onclick="add_row()">
                <i class="ti ti-plus fs-16 me-1"></i>{{ __('transaction.add_row') }}
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped transaction-create-table">
                    <thead>
                        <tr>
                            <th>{{ __('transaction.date') }}</th>
                            <th style="width: 150px !important;">{{ __('transaction.account') }}</th>
                            <th>{{ __('transaction.balance') }}</th>
                            <th>{{ __('transaction.location') }}</th>
                            <th>{{ __('transaction.number') }}</th>
                            <th style="width: 200px !important;">{{ __('transaction.description') }}</th>
                            <th class="text-success">{{ __('transaction.credit') }}</th>
                            <th class="text-danger">{{ __('transaction.debit') }}</th>
                            <th class="text-success">{{ __('transaction.toman') }}</th>
                            <th class="text-danger">{{ __('transaction.toman') }}</th>
                            <th class="text-success">{{ __('transaction.dollar') }}</th>
                            <th class="text-danger">{{ __('transaction.dollar') }}</th>
                            <th class="text-success">{{ __('transaction.afg') }}</th>
                            <th class="text-danger">{{ __('transaction.afg') }}</th>
                            <th style="width: 10px !important;"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr id="trRow_0">
                            <td class="p-1"><input type="date" name="date[]" value="{{ date('Y-m-d') }}"
                                    id="date_0" class="form-control p-1 h-100"></td>
                            <td class="p-1"><select name="account[]" id="account_0" class="form-select p-1 h-100 account-select">
                                    @foreach ($accounts as $account)
                                        @php
                                            $words = explode(' ', $account->name);
                                            $translatedWords = [];
                                            foreach ($words as $word) {
                                                $lowerWord = strtolower(trim($word));
                                                $lowerWord = preg_replace('/[^\w\s]/u', '', $lowerWord);
                                                if (Lang::has('accounts.' . $lowerWord)) {
                                                    $translatedWords[] = __('accounts.' . $lowerWord);
                                                } else {
                                                    $translatedWords[] = $word;
                                                }
                                            }
                                            $translatedName = implode(' ', $translatedWords);
                                            $displayText = ($translatedName !== $account->name) ? "{$account->name} - {$translatedName}" : $account->name;
                                        @endphp
                                        <option value="{{ $account->id }}">{{ $displayText }}</option>
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
                                    class="form-control p-1 h-100 "></td>
                            <td class="p-1"><input type="number" step="0.01" name="credit[]" id="credit_0"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="debit[]" id="debit_0"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="toman_credit[]"
                                    id="toman_credit_0" class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="toman_debit[]" id="toman_debit_0"
                                    class="form-control p-1 h-100 text-center">
                            </td>
                            <td class="p-1"><input type="number" step="0.01" name="dollar_credit[]"
                                    id="dollar_credit_0" class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="dollar_debit[]"
                                    id="dollar_debit_0" class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="afg_credit[]" id="afg_credit_0"
                                    class="form-control p-1 h-100 text-center">
                            </td>
                            <td class="p-1"><input type="number" step="0.01" name="afg_debit[]" id="afg_debit_0"
                                    class="form-control p-1 h-100 text-center">
                            </td>
                            <td class="p-1"><a href="javascript:void(0);" class="btn btn-success btn-sm"
                                    onclick="add_row()"><i class="ti ti-plus"></i></a>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let rowIndex = 1;

        $(document).ready(function() {
            $('.account-select').select2({
                width: '100%'
            });
        });

        function add_row() {
            let tbody = document.getElementById('tbody');
            let tr = document.createElement('tr');
            tr.id = 'trRow_' + rowIndex;
            tr.innerHTML = `
                            <td class="p-1"><input type="date" name="date[]" value="{{ date('Y-m-d') }}"
                                    id="date_${rowIndex}" class="form-control p-1 h-100"></td>
                            <td class="p-1"><select name="account[]" id="account_${rowIndex}" class="form-select p-1 h-100 account-select">
                                    @foreach ($accounts as $account)
                                        @php
                                            $words = explode(' ', $account->name);
                                            $translatedWords = [];
                                            foreach ($words as $word) {
                                                $lowerWord = strtolower(trim($word));
                                                $lowerWord = preg_replace('/[^\w\s]/u', '', $lowerWord);
                                                if (Lang::has('accounts.' . $lowerWord)) {
                                                    $translatedWords[] = __('accounts.' . $lowerWord);
                                                } else {
                                                    $translatedWords[] = $word;
                                                }
                                            }
                                            $translatedName = implode(' ', $translatedWords);
                                            $displayText = ($translatedName !== $account->name) ? "{$account->name} - {$translatedName}" : $account->name;
                                        @endphp
                                        <option value="{{ $account->id }}">{{ $displayText }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-1"><input type="number" readonly id="balance_${rowIndex}"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="text" name="location[]" id="location_${rowIndex}"
                                    class="form-control p-1 h-100"></td>
                            <td class="p-1"><input type="text" name="number[]" id="number_${rowIndex}"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="text" name="description[]" id="description_${rowIndex}"
                                    class="form-control p-1 h-100 "></td>
                            <td class="p-1"><input type="number" step="0.01" name="credit[]" id="credit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="debit[]" id="debit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="toman_credit[]"
                                    id="toman_credit_${rowIndex}" class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="toman_debit[]" id="toman_debit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center">
                            </td>
                            <td class="p-1"><input type="number" step="0.01" name="dollar_credit[]"
                                    id="dollar_credit_${rowIndex}" class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="dollar_debit[]"
                                    id="dollar_debit_${rowIndex}" class="form-control p-1 h-100 text-center"></td>
                            <td class="p-1"><input type="number" step="0.01" name="afg_credit[]" id="afg_credit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center">
                            </td>
                            <td class="p-1"><input type="number" step="0.01" name="afg_debit[]" id="afg_debit_${rowIndex}"
                                    class="form-control p-1 h-100 text-center">
                            </td>
                            <td class="p-1"><a href="javascript:void(0);" class="btn btn-danger btn-sm removeBtn" data-index="${rowIndex}"><i
                                        class="ti ti-trash"></i></a>
                            </td>
            `;
            tbody.appendChild(tr);
            
            // Initialize Select2 on the new select element
            $('#account_' + rowIndex).select2({
                width: '100%'
            });

            rowIndex++;
        }

        $(document).on('click', '.removeBtn', function() {
            var index = $(this).data('index');
            $('#trRow_' + index).remove();
        });
    </script>
@endsection
