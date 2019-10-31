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
                        @foreach ($product_sources as $key => $product_source)
                          <option value="{{$key}}"
                          @if(request()->get('product_source') && request()->get('product_source') == $key)
                            selected
                          @endif>
                          {{$product_source}}</option>
                        @endforeach

                      </select>
                    </div>
                  </div>
                  <div class="col-md-3" id="select_shop"
                  style="{{
                    (request()->get('product_source') && request()->get('product_source') == 2) ? 'display:block' : 'display:none'
                  }}"
                  >
                  <div class="form-group">
                    <label for="shop_id">Mağaza</label>
                    <select class="form-control" id="shop_id" name="shop_id">
                      @foreach ($shops as $key => $shop)
                        <option value="{{$key}}"
                        @if(request()->get('shop_id') && request()->get('shop_id') == $key)
                          selected
                        @endif>
                        {{$shop}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <label>&nbsp; </label>
                  <button type="submit" name="submit" class="btn btn-success form-control">
                    Davam et
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <br/><br/>

        @if (\Session::has('error'))
          <div class="alert alert-danger">
            {!! \Session::get('error') !!}
          </div>
          <br/><br/>
        @endif

        @if (\Session::has('success'))
          <div class="alert alert-success">
            {!! \Session::get('success') !!}
          </div>
          <br/><br/>
        @endif

        @if($result)
          <div class="row">
            <div class="col-md-12 table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Məhsulun nömrəsi</th>
                    <th>Mağaza</th>
                    <th>Baxış sayı</th>
                    <th>Baxış sayı (Unikal)</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($result) > 0)
                    @foreach ($result as $key => $product)
                      <tr>
                        <td>{{$product->product_id}}</td>
                        <td>{{$product->shop_id}}</td>
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
