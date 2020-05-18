@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Mağazalar</h1>
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
                      <th>Mağaza ID</th>
                      <th>Mağazanın adı</th>
                      <th>Baxış sayı</th>
                      <th>Baxış sayı (Unikal)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($result) > 0)
                      @foreach ($result as $key => $shop)
                        <tr>
                          <td>{{$shop->shop_id}}</td>
                          <td>{{($shop->shop) ? $shop->shop->name : ''}}</td>
                          <td>{{$shop->sum_click_count}}</td>
                          <td>{{$shop->sum_click_count_unique}}</td>
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

  $('.daterange-cus').daterangepicker({
    locale: {format: 'YYYY-MM-DD'},
    drops: 'down',
    opens: 'right'
  });

  </script>
@endpush
