<div>
    <div class="container" style="padding: 30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <b> All Coupons</b>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-success pull-right">Add New</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Coupon Code</th>
                                <th scope="col">Coupon Type</th>
                                <th scope="col">Coupon Value</th>
                                <th scope="col">Cart Value</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <th scope="row">{{$coupon->id}}</th>
                                <td>{{$coupon->code}}</td>
                                <td>{{$coupon->type}}</td>
                                @if($coupon->type=='fixed')
                                <td>${{$coupon->value}}</td>
                                @else
                                <td>{{$coupon->value}}%</td>
                                @endif
                                <td>{{$coupon->cart_value}}</td>
                                <td>{{$coupon->expiry_date}}</td>
                                <td>Edit || Delete</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>