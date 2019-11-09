@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Sosial şəbəkə hesabatı</h1>
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



            <div class="row">
              <div class="col-md-12 table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Hesabat İD</th>
                      <th>Tarix</th>
                      <th>Məhsul</th>
                      <th>Mağaza</th>
                      <th>Status</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td>352523</td>
                      <td>08-11-2019 13:33</td>
                      <td><a target="_blank" href="#">#38412 - Güzgü şüşəsi sol Audi</a></td>
                      <td>Volkswagen Baki Mərkəzi</td>
                      <td><span class="btn btn-warning btn-sm">Cavab gözləyir</span></td>
                      <td><button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button></td>
                      <td><button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button></td>
                    </tr>

                  </tbody>
                </table>
              </div>

            </div>

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
