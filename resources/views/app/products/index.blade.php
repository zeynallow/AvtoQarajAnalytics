@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Məhsullar</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-md-12">
              <form class="" action="" method="get">

                <div class="row">
                  <div class="col-md-4">

                    <div class="form-group">
                      <label>Tarixlər</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" name="date_range"
                        value="{{(request()->get('date_range')) ? request()->get('date_range') : ''}}"
                        class="form-control daterange-cus">
                      </div>
                    </div>

                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="product_source">Məhsulun mənbəyi</label>
                      <select class="form-control" id="product_source" name="product_source">
                        @if(auth()->user()->role_id == 1)
                          @foreach ($product_sources as $key => $product_source)
                            <option value="{{$key}}"
                            @if(request()->get('product_source') && request()->get('product_source') == $key)
                              selected
                            @endif>
                            {{$product_source}}</option>
                          @endforeach
                        @elseif(auth()->user()->role_id == 2)
                          <option value="2">Mağaza</option>
                        @endif

                      </select>
                    </div>
                  </div>
                  <div class="col-md-3" id="select_shop"
                  @if(auth()->user()->role_id == 1)
                    style="{{
                      (request()->get('product_source') && request()->get('product_source') == 2) ? 'display:block' : 'display:none'
                    }}"
                  @elseif(auth()->user()->role_id == 2)
                    style="display:block"
                  @endif
                  >
                  <div class="form-group">
                    <label for="shop_id">Mağaza</label>
                    <select class="form-control" id="shop_id" name="shop_id">
                      @if(auth()->user()->role_id == 1)
                        <option value="all">Bütün mağazalar</option>
                        @foreach ($shops as $key => $shop)
                          <option value="{{$shop->id}}"
                            @if(request()->get('shop_id') && request()->get('shop_id') == $shop->id)
                              selected
                            @endif>
                            {{$shop->name}}</option>
                          @endforeach
                        @elseif(auth()->user()->role_id == 2)
                          @if(auth()->user()->shop)
                            <option value="{{auth()->user()->shop->id}}">{{auth()->user()->shop->name}}</option>
                          @endif
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label>&nbsp; </label>
                    <button type="submit" name="submit" class="btn btn-primary form-control">
                      Davam et
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <br/>

          @if (\Session::has('error'))
            <div class="alert alert-danger">
              {!! \Session::get('error') !!}
            </div>
            <br/>
          @endif

          @if (\Session::has('success'))
            <div class="alert alert-success">
              {!! \Session::get('success') !!}
            </div>
            <br/>
          @endif


          @if(!$result)
            <div class="alert alert-info">
              Sorğunu daxil edin
            </div>
          @elseif($result && count($result))
            <div class="row">
              <div class="col-md-12 text-right">
                <a class="btn btn-success" href="{{ request()->fullUrl() . '&export=excel' }}"><i class="fa fa-file-excel"></i> Export</a>
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="col-md-12 table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Məhsulun nömrəsi</th>
                      <th>Məhsulun adı</th>
                      <th>Mağaza</th>
                      <th><a class="order" href="{{$order_url_sum_click_count}}">Baxış sayı <i class="fa fa-arrows-alt-v"></i></a></th>
                      <th><a class="order" href="{{$order_url_sum_click_count_unique}}">Baxış sayı (Unikal) <i class="fa fa-arrows-alt-v"></i></a></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($result) > 0)
                      @foreach ($result as $key => $product)
                        <tr>
                          <td><a target="_blank" href="{{env('PRIMARY_WEB_URL')}}/product/{{$product->product_id}}">{{$product->product_id}}</a></td>
                          <td>{{($product->product) ? $product->product->product_name : ''}}</td>
                          <td>{{($product->shop) ? $product->shop->name : ''}}</td>
                          <td>{{$product->sum_click_count}}</td>
                          <td>{{$product->sum_click_count_unique}}</td>
                        </tr>
                      @endforeach
                    @endif

                  </tbody>
                </table>
              </div>
              <div class="col-md-12">
                {{$result}}
              </div>
            </div>
          @else
            <div class="alert alert-danger">
              Sorğunun nəticəsi yoxdur
            </div>
          @endif

        </div>
      </div>
    </div>

  </section>
@endsection


@push('javascript')
  <script type="text/javascript">

  $("#product_source").change(function(){
    var product_source = $(this).val();

    if(product_source == 1 || product_source == 3){
      $("#select_shop").hide();
    }else if(product_source == 2){
      $("#select_shop").show();
    }else{
      $("#select_shop").hide();
    }

    $("#shop_id").val("all");
  });

  $('.daterange-cus').daterangepicker({
    locale: {format: 'YYYY-MM-DD'},
    drops: 'down',
    opens: 'right'
  });


  </script>
@endpush
