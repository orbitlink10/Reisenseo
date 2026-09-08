@extends('layouts.frontbar')

@section('content')

       

            <!--app-content open-->
            <div class="container">
                <div class="">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">



                        <!-- Row -->
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <form action="{{ route('qpost')}}" method="GET">
                                        <div class="input-group mb-2">
                                            <input name="q" type="text" class="form-control" placeholder="Searching.....">
                                            <button  class="input-group-text btn btn-primary">Search</button>
                                        </div>
                                        </form>

                                    </div>
                               
                                </div>
                               <div class="tab-content">
                                    <div class="tab-pane active" id="tab-11">
                                        <div class="row">
                                           @foreach($products as $product)       
                                            <div class="col-md-6 col-xl-4 col-sm-6">
                                                <div class="card">
                                                    <div class="product-grid6">
                                                        <div class="product-image6 p-5">
                                                            <ul class="icons">
                                                                <li>
                                                                    <a href="{{ route('shop-description', $product->slug ) }}" class="btn btn-primary"> <i class="fe fe-eye">  </i> </a>
                                                                </li>
                                                                <li><a href="add-product.html" class="btn btn-success"><i  class="fe fe-edit"></i></a></li>
                                                                <li><a href="javascript:void(0)" class="btn btn-danger"><i class="fe fe-x"></i></a></li>
                                                            </ul>
                                                            <a href="{{ route('shop-description', $product->slug ) }}" >
                                                                <img class="img-fluid br-7 w-100" src="assets/images/pngs/9.jpg" alt="img">
                                                            </a>
                                                        </div>
                                                        <div class="card-body pt-0">
                                                            <div class="product-content text-center">
                                                                <h1 class="title fw-bold fs-20"><a href="{{ route('shop-description', $product->slug ) }}">Candy Pure Rose Water</a></h1>
                                                                <div class="mb-2 text-warning">
                                                                    <i class="fa fa-star text-warning"></i>
                                                                    <i class="fa fa-star text-warning"></i>
                                                                    <i class="fa fa-star text-warning"></i>
                                                                    <i class="fa fa-star-half-o text-warning"></i>
                                                                    <i class="fa fa-star-o text-warning"></i>
                                                                </div>
                                                                <div class="price">$599<span class="ms-4">$799</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-center">
                                                            <a href="cart.html" class="btn btn-primary mb-1"><i class="fe fe-shopping-cart mx-2"></i>Add to cart</a>
                                                    <!--         <a href="wishlist.html" class="btn btn-outline-primary mb-1"><i class="fe fe-heart mx-2 wishlist-icon"></i>Add to wishlist</a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
 @endforeach

</div>
</div>
</div>



                                    
                                <div class="text-center">
                                    <div class="mb-5">
                                        <ul class="pagination justify-content-center">
                                          
                                             {{$products->links("pagination::bootstrap-4")}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- CONTAINER CLOSE -->

                </div>
            </div>
            @endsection