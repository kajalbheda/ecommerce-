<main id="main" class="main-site left-sidebar">
    <style>
        .fill-heart {
            color: red !important;
        }
    </style>
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span> Wishlist</span></li>
            </ul>
        </div>

        <div class="row">
            @if(Cart::instance('wishlist')->count() > 0)

            <ul class="product-list grid-products equal-container">


                @foreach(Cart::instance('wishlist')->content() as $item)
                <li class="col-lg-3 col-md-6 col-sm-6 col-xs-6 ">
                    <div class="product product-style-3 equal-elem ">
                        <div class="product-thumnail">
                            <a href="{{route('product.details',['slug'=>$item->model->slug])}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                <figure><img src="{{asset('assets/images/products')}}/{{$item->model->image}}" alt="{{$item->model->name}}"></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="{{route('product.details',['slug'=>$item->model->slug])}}" class="product-name"><span>{{$item->model->name}}</span></a>
                            <div class="wrap-price"><span class="product-price">{{$item->model->regular_price}}</span></div>

                            <a href="#" wire:click.prevent="moveProductFromWishlistToCart('{{$item->rowId}}')" class="btn add-to-cart">Move To Cart</a>
                            <div class="product-wish">

                                <a href="#" wire:click.prevent="removeFromWishlist({{$item->model->id}})" class="btn  fill-heart "><i class="fa fa-heart fill-heart"></i>Remove Wishlist</a>

                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <h3>No items in wishlist</h3>
            @endif

        </div>
    </div>
</main>