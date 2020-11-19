<div class="content-vote">
    @if (Auth::check() && Auth::user()->role_id == config('config.role_user') && (!isset($activeComment) || $activeComment == null))
        <div class="section-rating">
            <div class="rating-title">{{ trans('customer.review_product') }}</div>
            <div class="rating-content">
                <div class="rating-product"></div>
                <div class="rating-form">
                    <form action="{{ route('home.comment') }}" method="POST" accept-charset="utf-8" class="comment-form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <textarea name="content" placeholder="{{ trans('customer.content') }}" rows="3" required=""></textarea>
                        <button type="submit" class="btn btn-default">{{ trans('customer.send_vote') }}</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="show-rate">
        <div class="show-rate-header">
            {{ trans('customer.review_user') }}
        </div>
        <div class="show-rate-content">
            <div class="total-rate">
                <div class="total-rate-left">
                    {{ $product->rate }}
                </div>
                <div class="total-rate-right">
                    <div class="start">
                        @for ($i = 1; $i <= config('config.star_vote'); $i++)
                            @if ($product->rate >= $i )
                                <i class="fas fa-star"></i>
                            @elseif ( (int) $product->rate + 1 == $i && $product->rate - (int) $product->rate > 0)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="total-user">{{ count($comments) }}<i class="fas fa-users"></i></div>
                </div>
            </div>
            @if ($comments->isNotEmpty())
                <div class="vote-inner comment-user">
                    @if (isset($activeComment) && $activeComment != null)
                        <div class="vote-content bg-info">
                            <div class="vote-content-left">
                                <img src="{{ asset($activeComment->user->avatar) }}">
                            </div>
                            <div class="vote-content-right">
                                <div class="name">
                                    {{ $activeComment->user->name }}
                                </div>
                                <div class="vote-start">
                                    <div class="star">
                                        @for ($i = 1; $i <= config('config.star_vote'); $i++)
                                            @if ($activeComment->rate >= $i )
                                                <i class="fas fa-star"></i>
                                            @elseif ( (int) $activeComment->rate + 1 == $i  && $activeComment->rate - (int) $activeComment->rate > 0)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="date">{{ date_format($activeComment->created_at, config('config.format')) }}</div>
                                </div>
                                <div class="content">{{ $activeComment->content }}</div>
                            </div>
                            <div class="edit-delete">
                                <a href="javascript:;"  class="edit-comment"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('home.delete_comment') }}" method="POST" class="delete-comment-form">
                                    @csrf
                                    <input type="text" name="id"  value="{{ $activeComment->id }}" hidden="">
                                    <input type="text" name="product_id"  value="{{ $activeComment->product_id }}" hidden="">
                                    <a href="javascript:;" class="delete-comment"><i class="fas fa-trash-alt"></i></a>
                                </form>
                            </div>
                        </div>
                        @if ($activeComment->children)
                            <div class="vote-content bg-light reply">
                                <div class="vote-content-left">
                                    <img src="{{ asset($activeComment->children->user->avatar) }}">
                                </div>
                                <div class="vote-content-right">
                                    <div class="name">
                                        {{ $activeComment->children->user->name }}
                                    </div>
                                    <div class="date">{{ date_format($activeComment->children->created_at, config('config.format')) }}</div>
                                    <div class="content">{{ $activeComment->children->content }}</div>
                                </div>
                            </div>
                        @endif
                        <div class="vote-content">
                            <div class="edit-section-rating section-rating container edit-view-comment" >
                                <div class="rating-title">{{ trans('customer.edit_comment') }}
                                    <i class="fas fa-times remove-edit" ></i>
                                </div>
                                <div class="rating-content">
                                    <div class="rating-product"></div>
                                    <div class="rating-form ">
                                        <form action="{{ route('home.edit_comment') }}" method="POST" accept-charset="utf-8" class="edit-comment-rate-form">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="text" name="rate" class="input-rate-edit" value="{{ $activeComment->rate }}" hidden="">
                                            <input type="text" name="id"  value="{{ $activeComment->id }}" hidden="">
                                            <textarea name="content" placeholder="{{ trans('customer.content') }}" rows="3" required="">{{ $activeComment->content }}</textarea>
                                            <button type="submit" class="btn btn-default btn-form-edit-rate">{{ trans('customer.send_vote') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (session('activeComment'))
                        <div class="bg-info">
                            <div class="vote-content bg-info">
                                <div class="vote-content-left">
                                    <img src="{{ asset(session('activeComment')->user->avatar) }}">
                                </div>
                                <div class="vote-content-right">
                                    <div class="name">
                                        {{ session('activeComment')->user->name }}
                                    </div>
                                    <div class="vote-start">
                                        <div class="star">
                                            @for ($i = 1; $i <= config('config.star_vote'); $i++)
                                                @if (session('activeComment')->rate >= $i )
                                                    <i class="fas fa-star"></i>
                                                @elseif ( (int) session('activeComment')->rate + 1 == $i  && session('activeComment')->rate - (int) session('activeComment')->rate > 0)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="date">{{ date_format(session('activeComment')->created_at, config('config.format')) }}</div>
                                    </div>
                                    <div class="content">{{ session('activeComment')->content }}</div>
                                </div>
                                @if (Auth::check() && Auth::user()->role_id == config('config.role_supplier') && !session('activeComment')->children)
                                    <div>
                                        <i class="fa fa-reply comment-reply" aria-hidden="true" data-toggle="modal" data-target="#dialog1" data-id="{{ session('activeComment')->id }}"></i>
                                    </div>
                                @endif
                            </div>
                            @if (session('activeComment')->children)
                                <div class="vote-content ative-reply">
                                    <div class="vote-content-left">
                                        <img src="{{ asset(session('activeComment')->children->user->avatar) }}">
                                    </div>
                                    <div class="vote-content-right">
                                        <div class="name">
                                            {{ session('activeComment')->children->user->name }}
                                        </div>
                                        <div class="date">{{ date_format(session('activeComment')->children->created_at, config('config.format')) }}</div>
                                        <div class="content">{{ session('activeComment')->children->content }}</div>
                                    </div>
                                    @if (Auth::check() && Auth::user()->role_id == config('config.role_supplier'))
                                        <div>
                                            <i class="fas fa-edit edit-comment-reply" aria-hidden="true" data-toggle="modal" data-target="#dialog2" data-id="{{ session('activeComment')->id }}" data-id-children="{{ session('activeComment')->children->id }}"></i>
                                            <form action="" method="POST" class="delete-reply-comment-form-{{ session('activeComment')->children->id }}">
                                                @csrf
                                                <input type="text" name="id"  value="{{ session('activeComment')->children->id }}" hidden="">
                                                <input type="text" name="product_id"  value="{{ $product->id }}" hidden="">
                                                <a href="javascript:;" class="delete-reply-comment" data-mess="{{ trans('customer.delete_message') }}" data-url="{{ route('home.delete_reply') }}" data-id="{{ session('activeComment')->children->id }}"><i class="fas fa-trash-alt delete-reply-icon"></i></a>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                    @foreach ($comments as $comment)
                        @if ((!isset($activeComment) || $activeComment == null) && !session('activeComment'))
                            @include('layouts.comment_mini', ['comment' => $comment])
                        @elseif(!session('activeComment') && $comment->id != $activeComment->id)
                            @include('layouts.comment_mini', ['comment' => $comment])
                        @elseif (session('activeComment') && $comment->id != session('activeComment')->id)
                            @include('layouts.comment_mini', ['comment' => $comment])
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-center"><strong>{{ trans('customer.no_review') }}</strong></p>
            @endif
        </div>
    </div>
</div>
