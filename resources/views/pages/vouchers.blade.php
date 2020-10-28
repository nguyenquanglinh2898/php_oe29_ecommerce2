<div class="container-fluid">
    <div class="list-vouchers">
        @foreach ($vouchers as $voucher)
            <div class="pop-up-voucher">
                <label for="voucher{{ $voucher->id }}">
                    <div class="left">
                        <div class="name">{{ $voucher->name }}</div>
                    </div>
                    <div class="right">
                        <div class="description">
                            <span class="title">{{ trans('sentences.description') }}: </span>
                            <span class="content">{{ $voucher->description }}</span>
                        </div>
                        <div class="quantity">
                            <span class="title">{{ trans('sentences.quantity') }}: </span>
                            <span class="content">{{ $voucher->quantity }}</span>
                        </div>
                        <div class="end-date">
                            <span class="title">{{ trans('sentences.expire_date') }}: </span>
                            <span class="content">{{ $voucher->end_date }}</span>
                        </div>
                    </div>
                </label>
                @if ($currentVoucherId == $voucher->id)
                    <input type="radio" id="voucher{{ $voucher->id }}" name="voucher" value="{{ $voucher->id }}" checked="checked">
                @else
                    <input type="radio" id="voucher{{ $voucher->id }}" name="voucher" value="{{ $voucher->id }}">
                @endif
            </div>
        @endforeach
    </div>
</div>
