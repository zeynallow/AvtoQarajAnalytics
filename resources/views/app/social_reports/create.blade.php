@extends('layouts.app')

@push('javascript')
  <script type="text/javascript">
  function getProductInfo(){
    var product_id = $("#product_id").val();

    $("#shop_id").val(" ");
    $("#product_name").val(" ");

    if(product_id < 1){
      $("#product_id").removeClass('is-valid').addClass('is-invalid');
    }

    $.ajax({
      url: '{{ route('social_reports.getProductInfo',['product_id'=>""]) }}/'+product_id,
      method:'GET',
      success:function(response){
        if(response.message == "error"){
          $("#product_id").removeClass('is-valid').addClass('is-invalid');
        }else{
          $("#product_id").removeClass('is-invalid').addClass('is-valid');

          $("#shop_id").val(response.shop_id);
          $("#product_name").val(response.product_name);

        }
      },
      error:function(response){
        $("#product_id").removeClass('is-valid').addClass('is-invalid');
      }
    });


  }



</script>
@endpush
@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Müraciət yarat</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

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

          <form class="" action="{{route('social_reports.store')}}" method="post">
            @csrf
            <div class="row">

              <div class="col-md-3">
                <label for="network_type">Sosial şəbəkə</label>
                <select class="form-control" name="network_type">
                  <option value="1">Facebook</option>
                  <option value="2">Instagram</option>
                  <option value="3">Whatsapp</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="network_type">Məhsul ID</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="product_id" id="product_id" value="{{ old('product_id') }}">
                  <div class="input-group-append">
                    <button type="button" onclick="getProductInfo()" class="input-group-text"><i class="fa fa-search"></i></button>
                  </div>
                  <span class="invalid-feedback " role="alert">
                    <strong>Məhsul tapılmadı</strong>
                  </span>
                </div>

              </div>

              <div class="col-md-3">
                <label for="product_name">Məhsulun adı</label>
                <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name') }}">
              </div>

              <div class="col-md-3">
                <label for="shop_name">Mağaza</label>
                <select class="form-control" id="shop_id" name="shop_id">
                  <option value=""></option>
                  @foreach ($shops as $key => $shop)
                    @if(old('shop_id') == $shop->id)
                      <option value="{{$shop->id}}" selected>{{$shop->name}}</option>
                    @else
                      <option value="{{$shop->id}}">{{$shop->name}}</option>
                    @endif

                  @endforeach
                </select>

              </div>

            </div>
            <br/>

            <div class="row">
              <div class="col-md-3">
                <label for="client_name">Müştərinin adı</label>
                <input type="text" class="form-control" name="client_name" id="client_name" value="{{ old('client_name') }}">
              </div>
              <div class="col-md-3">
                <label for="client_contact">Müştərinin əlaqə nömrəsi</label>
                <input type="text" class="form-control" name="client_contact" id="client_contact" value="{{ old('client_contact') }}">
              </div>

              <div class="col-md-3">
                <label for="client_auto_car">Avtomobil</label>
                <input type="text" class="form-control" name="client_auto_car" id="client_auto_car" value="{{ old('client_auto_car') }}">
              </div>
              <div class="col-md-3">
                <label for="client_auto_year">Avtomobilinin ili</label>
                <input type="text" class="form-control" name="client_auto_year" id="client_auto_year" value="{{ old('client_auto_year') }}">
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="col-md-3">
                <label for="client_auto_vin">Avtomobilin ban nömrəsi</label>
                <input type="text" class="form-control" name="client_auto_vin" id="client_auto_vin" value="{{ old('client_auto_vin') }}">
              </div>
              <div class="col-md-9">
                <label for="client_comment">Müştərinin şərhi</label>
                <input type="text" class="form-control" name="client_comment" id="client_comment" value="{{ old('client_comment') }}">
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-success form-control">Yarat</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>
@endsection
