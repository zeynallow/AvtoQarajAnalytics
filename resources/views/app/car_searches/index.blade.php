@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Avtomobil axtarışı</h1>
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
