@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Mağaza avtomobilləri</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          @if (\Session::has('success'))
            <div class="alert alert-success">
              {!! \Session::get('success') !!}
            </div>
            <br/>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('users.shop_cars_store') }}" method="post">

            <div class="form-group">
              <label for="shop_id">İstifadəçi</label>
              <select class="form-control" name="user_id" id="user_id">
                <option value="0">Seçin</option>
                @foreach ($users as $key => $user)
                  <option value="{{$user->id}}">{{$user->email}} - {{($user->shop) ? $user->shop->name : ''}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="car_type">Nəqliyyatın növü</label>
              <select class="form-control" name="id_car_type" id="id_car_type">
                <option value="0">Seçin</option>
                @foreach ($car_types as $key => $car_type)
                  <option value="{{$car_type->id_car_type}}">{{$car_type->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="car_make">Marka</label>
              <select class="form-control" name="id_car_make" id="id_car_make">
                <option value="0">Seçin</option>
              </select>
            </div>

            <br/>
            <div class="form-group">
              @csrf
              <button type="submit" class="btn btn-success">Əlavə et</button>
            </div>


          </form>

        </div>
      </div>
    </div>

  </section>
@endsection
@push('javascript')
  <script type="text/javascript">

  /* Car Type Change */
  $('#id_car_type').on("change",function(){

    var car_type = $(this).val();

    $('#id_car_make').empty().append('<option value="0">Seçin</option>');

    $.ajax({
      url: "/api/cardata/getMake/"+$(this).val(),
      dataType: 'json',
      async: true,
      success: function(json){
        $.each(json, function(key, value){
          $('#id_car_make').append('<option value="' + value.id_car_make + '">' + value.name + '</option>');
        });
      }
    });

  });
  </script>
@endpush
