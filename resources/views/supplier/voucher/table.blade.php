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
                    {{ $key }}
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
                    <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-icon btn-sm btn-info"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-id="{{ $voucher->id }}" class="btn btn-icon btn-sm btn-danger deleteDialog tip"  data-url="{{ route('vouchers.destroy')}}" data-noti="{{ trans('supplier.notification') }}" data-mess="{{ trans('supplier.mess') }}">
                        <i class="fa fa-trash"></i>
                    </a>
                    <form class="remove_form" hidden="">
                        @csrf
                        <input type="text" name="id" hidden="" value="{{ $voucher->id }}">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script src="{{ asset('js/supplier/voucher/index.js') }}"></script>
