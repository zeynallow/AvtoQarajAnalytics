@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Sosial şəbəkə müraciətləri</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">
          @if($reports)
            <div class="row">
              <div class="col-md-12 table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Hesabat İD</th>
                      <th>Əlavə olunma</th>
                      <th>Məhsul</th>
                      <th>Mağaza</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($reports as $key => $report)
                      <tr>
                        <td>{{$report->id}}</td>
                        <td>{{$report->created_at}}</td>
                        <td><a target="_blank" href="{{env('PRIMARY_WEB_URL')}}/product/{{$report->product_id}}">#{{$report->product_id}} - {{$report->product_name}}</a></td>
                        <td>{{($report->getShop)? $report->getShop->name : ''}}</td>
                        <td>
                          @if($report->report_status == 1)
                            <span class="btn btn-warning btn-sm">Cavab gözləyir</span>
                          @elseif($report->report_status == 2)
                            <span class="btn btn-danger btn-sm">Mağaza İmtina</span>
                          @elseif($report->report_status == 3)
                            <span class="btn btn-success btn-sm">Mağaza cavablayıb</span>
                          @elseif($report->report_status == 4)
                            <span class="btn btn-success btn-sm">Avtoqaraj cavablayıb</span>
                          @elseif($report->report_status == 5)
                            <span class="btn btn-danger btn-sm">Avtoqaraj İmtina</span>
                          @endif
                        </td>
                        <td>
                          <button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
                          @if($report->report_status == 1)
                            <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id])}}" class="btn btn-success btn-sm check-confirm-alert"><i class="fa fa-check"></i></a>
                            <a href="{{route('social_reports.cancelRequest',['request_id'=>$report->id])}}" class="btn btn-danger btn-sm confirm-alert"><i class="fa fa-times"></i></a>
                          @elseif($report->report_status == 2)
                            <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id])}}" class="btn btn-success btn-sm check-confirm-alert"><i class="fa fa-check"></i></a>
                          @endif
                        </td>
                      </tr>
                    @endforeach


                  </tbody>
                </table>
              </div>
              <div class="col-md-12">
                {{$reports}}
              </div>

            </div>
          @endif

        </div>
      </div>
    </div>

  </section>
@endsection

@push('javascript')
  <script type="text/javascript" src="/js/bootbox.min.js"></script>
  <script type="text/javascript">


  $(document).on("click", ".confirm-alert", function(e) {
    e.preventDefault();
    var href = $(this).attr('href');

    bootbox.confirm({
      title: "İmtina etmək",
      message: "Müraciətdən imtina etmək istəyirsiniz?",
      buttons: {
        cancel: {
          label: '<i class="fa fa-times"></i> Xeyir'
        },
        confirm: {
          label: '<i class="fa fa-check"></i> Bəli'
        }
      },
      callback: function (result) {
        if(result){
          window.location = href;
        }
      }
    });
  });


  $(document).on("click", ".check-confirm-alert", function(e) {
    e.preventDefault();
    var href = $(this).attr('href');

    bootbox.confirm({
      title: "Təsdiq etmək",
      message: "Müraciəti cavabladınız? ",
      buttons: {
        cancel: {
          label: '<i class="fa fa-times"></i> Xeyir'
        },
        confirm: {
          label: '<i class="fa fa-check"></i> Bəli'
        }
      },
      callback: function (result) {
        if(result){
          window.location = href;
        }
      }
    });
  });


  </script>
@endpush
