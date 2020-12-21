<table id="advertise-table" class="table table-hover" style="">
    <thead>
        <tr>
            <th data-width="10px">ID</th>
            <th data-orderable="false" data-width="100px">{{ trans('supplier.code') }}</th>
            <th data-orderable="false">{{ trans('supplier.description') }}</th>
            <th data-orderable="false" data-width="85px">{{ trans('supplier.quantity') }}</th>
            <th data-width="60px" data-type="date-euro">{{ trans('supplier.min_value') }}</th>
            <th data-width="66px">{{ trans('supplier.discount') }}</th>
            <th data-width="66px">{{ trans('supplier.freeship') }}</th>
            <th data-width="66px">{{ trans('supplier.start_date') }}</th>
            <th data-width="66px">{{ trans('supplier.end_date') }}</th>
            <th data-width="66px">{{ trans('supplier.status') }}</th>
            <th data-orderable="false" data-width="70px">{{ trans('supplier.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vouchers as $key => $voucher)
            <tr>
                <td class="text-center">
                    {{ $key + 1 }}
                </td>
                <td>
                    {{ $voucher->name }}
                </td>
                <td>
                    <a href="javascript:void(0);" class="text-left" title="{{ $voucher->description }}">{{ $voucher->description }}</a>
                </td>
                <td>
                    {{ $voucher->quantity }}
                </td>
                <td> {{ $voucher->min_value }}</td>
                <td> @if ($voucher->discount != config('config.default'))
                    {{ $voucher->discount }}
                @endif</td>
                <td>
                    @if ($voucher->freeship != null)
                        {{ trans('supplier.freeship') }}
                    @endif
                </td>
                <td>{{ $voucher->start_date }}</td>
                <td>{{ $voucher->end_date }}</td>
                <td>
                    @if ($voucher->start_date <= \Carbon\Carbon::now() && $voucher->end_date >= \Carbon\Carbon::now())
                        <span class="label-success status-label">{{ trans('supplier.active') }}</span>
                    @else
                        <span class="label-danger status-label">{{ trans('supplier.out_of_time') }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-icon btn-sm btn-info action-edit"><i class="fa fa-edit"></i></a>
                    <button type="button" class="btn btn-danger fa fa-trash action-delete" data-toggle="modal" data-target="#delete-{{ $voucher->id }}"></button>
                    <div class="modal fade" id="delete-{{ $voucher->id }}" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{ trans('sentences.comfirm_delete') }}
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('vouchers.destroy', [$voucher->id]) }}">
                                        @csrf
                                        <input type="submit" class="btn btn-danger" value="{{ trans('sentences.yes') }}">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('sentences.no') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script src="{{ asset('js/supplier/voucher/index.js') }}"></script>
