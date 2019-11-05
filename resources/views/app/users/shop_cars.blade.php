@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Mağaza avtomobilləri <a class="btn btn-success btn-sm" href="{{ route('users.shop_cars_create') }}">+ Əlavə et</a></h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-md-12">

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

          @if(count($shop_user_cars))
            <div class="row">
              <div class="col-md-12 table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>İstifadəçi</th>
                      <th>Nəqliyyatın növü</th>
                      <th>Marka</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($shop_user_cars) > 0)
                      @foreach ($shop_user_cars as $key => $shop_user_car)
                        <tr>
                          <td>
                            {{($shop_user_car->user) ? $shop_user_car->user->email .' - '. $shop_user_car->user->shop->name: ''}}
                          </td>
                          <td>{{($shop_user_car->car_type) ? $shop_user_car->car_type->name : ''}}</td>
                          <td>{{($shop_user_car->car_make) ? $shop_user_car->car_make->name : ''}}</td>
                          <td><a href="{{ route('users.shop_cars_delete',$shop_user_car->id)}}" class="btn btn-danger"><i class="fa fa-times"></i></a></td>
                        </tr>
                      @endforeach
                    @endif

                  </tbody>
                </table>
              </div>
              <div class="col-md-12">
                {{$shop_user_cars}}
              </div>
            </div>
          @else
            <div class="alert alert-danger">
              Nəticə yoxdur
            </div>
          @endif

        </div>
      </div>
    </div>

  </section>
@endsection
