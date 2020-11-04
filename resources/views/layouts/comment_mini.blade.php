<div class="vote-content">
    <div class="vote-content-left">
        <img src="{{ asset($comment->user->avatar) }}">
    </div>
    <div class="vote-content-right">
        <div class="name">
            {{ $comment->user->name }}
        </div>
        <div class="vote-start">
            <div class="star">
                @for ($i = 1; $i <= config('config.star_vote'); $i++)
                    @if ($comment->rate >= $i )
                        <i class="fas fa-star"></i>
                    @elseif ( (int) $comment->rate + 1 == $i && $comment->rate - (int) $comment->rate > 0)
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <div class="date">{{ date_format($comment->created_at, config('config.format')) }}</div>
        </div>
        <div class="content">{{ $comment->content }}</div>
    </div>
    @if (Auth::check() && Auth::user()->role_id == config('config.role_supplier') && !$comment->children)
        <div >
            <i class="fa fa-reply comment-reply" aria-hidden="true" data-toggle="modal" data-target="#dialog1" data-id="{{ $comment->id }}"></i>
        </div>
    @endif
</div>
@if ($comment->children)
    <div class="vote-content bg-light reply">
        <div class="vote-content-left">
            <img src="{{ asset($comment->children->user->avatar) }}">
        </div>
        <div class="vote-content-right">
            <div class="name">
                {{ $comment->children->user->name }}
            </div>
            <div class="date">{{ date_format($comment->created_at, config('config.format')) }}</div>
            <div class="content">{{ $comment->children->content }}</div>
        </div>
        @if (Auth::check() && Auth::user()->role_id == config('config.role_supplier'))
            <div>
                <i class="fas fa-edit edit-comment-reply" aria-hidden="true" data-toggle="modal" data-target="#dialog2" data-id="{{ $comment->id }}" data-id-children="{{ $comment->children->id }}"></i>
                <form action="" method="POST" class="delete-reply-comment-form-{{ $comment->children->id }}">
                    @csrf
                    <input type="text" name="id"  value="{{ $comment->children->id }}" hidden="">
                    <input type="text" name="product_id"  value="{{ $product->id }}" hidden="">
                    <a href="javascript:;" class="delete-reply-comment" data-mess="{{ trans('customer.delete_message') }}" data-url="{{ route('home.delete_reply') }}" data-id="{{ $comment->children->id }}"><i class="fas fa-trash-alt delete-reply-icon"></i></a>
                </form>
            </div>
        @endif
    </div>
@endif
