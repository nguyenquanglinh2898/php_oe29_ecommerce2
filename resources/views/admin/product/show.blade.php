<div class="container-fluid">
    <div class="row">
        <label class="attr-name">{{ trans('sentences.product_name') }}:</label>
        <span>&ensp;{{ $product->name }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.weight') }}:</label>
        <span>&ensp;{{ $product->weight }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.brand') }}:</label>
        <span>&ensp;{{ $product->brand }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.product_description') }}:</label>
        <i class="fa fa-minus mini-content" title="{{ trans('sentences.detail') }}"></i>
        <div class="description mini-area">
            {!! $product->description !!}
        </div>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.thumbnail') }}:</label>
        <span>
            <img src="{{ $product->thumbnail }}" class="thumbnail-img">
        </span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.product_detail_info') }}:</label>
        <i class="fa fa-minus mini-content" title="{{ trans('sentences.detail') }}"></i>
        <div class="detail-info mini-area">
            {!! $product->detail_info !!}
        </div>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.rate') }}:</label>
        <span>&ensp;{{ $product->rate }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.remaining') }}:</label>
        <span>&ensp;{{ $product->remaining }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.status') }}:</label>
        <span>&ensp;
            @if ($product->status == config('setting.pending_id'))
                {{ trans('sentences.pending') }}
            @elseif ($product->status == config('setting.active_id'))
                {{ trans('sentences.active') }}
            @else
                {{ trans('sentences.blocked') }}
            @endif
        </span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.created_at') }}:</label>
        <span>&ensp;{{ $product->created_at }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.category') }}:</label>
        <span>&ensp;{{ $product->category->name }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.supplier') }}:</label>
        <span>&ensp;{{ $product->user->name }}</span>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.detail_images') }}:</label>
        <div class="other-pics">
            @foreach ($product->images as $image)
                <div class="image-div">
                    <img src="{{ $image->url }}">
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <label class="attr-name">{{ trans('sentences.classifying_product') }}:</label>
        <table class="table table-bordered table-dark">
            <tr>
                <th>#</th>
                <th>{{ trans('sentences.classification_attributes') }}</th>
                <th>{{ trans('sentences.remaining') }}</th>
                <th>{{ trans('sentences.sale_price') }}</th>
            </tr>
            @for ($i = 0; $i < count($product->productDetails); $i++)
                <tr>
                    <td>
                        <b>{{ $i + 1 }}</b>
                    </td>
                    <td>
                        @foreach (json_decode($product->productDetails[$i]->list_attributes) as $key => $value)
                            <p><b>{{ $key }}</b>: {{ $value }}</p>
                        @endforeach
                    </td>
                    <td>
                        {{ $product->productDetails[$i]->remaining }}
                    </td>
                    <td>
                        {{ $product->productDetails[$i]->price }}
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="modal-footer">
        @if ($product->status == config('setting.active_id'))
            <form action="{{ route('admin.products.change_status', ['product' => $product->id, 'status' => config('setting.blocked_id')]) }}" method="post" class="change-status-btn">
                @csrf
                <button type="submit" class="btn btn-danger">{{ trans('sentences.block') }}</button>
            </form>
        @else
            <form action="{{ route('admin.products.change_status', ['product' => $product->id, 'status' => config('setting.active_id')]) }}" method="post" class="change-status-btn">
                @csrf
                <button type="submit" class="btn btn-success">{{ trans('sentences.active') }}</button>
            </form>
        @endif
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('sentences.close') }}</button>
    </div>
</div>

<script src="{{ asset('js/admin/product/show.js') }}"></script>
