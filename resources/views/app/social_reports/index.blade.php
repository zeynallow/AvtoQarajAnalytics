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
                      <th>Sosial Şəbəkə</th>
                      <th>Məhsul</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($reports as $key => $report)
                      @php
                      $calc_hour = $report->updated_at->diffInHours(\Carbon\Carbon::now(),false);
                      if($calc_hour >= 1 && $report->report_status == 1){
                        $bg_color = 'background-color:#fc534b38';
                      }else{
                        $bg_color=NULL;
                      }
                      @endphp
                      <tr style="{{$bg_color}}">
                        <td>{{$report->id}}</td>
                        <td>{{$report->created_at}}</td>
                        <td>
                          @if($report->network_type == 1)
                            Facebook
                          @elseif($report->network_type == 2)
                            Instagram
                          @elseif($report->network_type == 3)
                            Whatsapp
                          @endif
                        </td>
                        <td width="20%">
                          @if($report->product_id)
                            <a target="_blank" href="{{env('PRIMARY_WEB_URL')}}/product/{{$report->product_id}}">#{{$report->product_id}} - {{$report->product_name}}</a>
                          @else
                            {{$report->product_name}}
                          @endif
                        </td>
                        <td>
                          @if($report->report_status == 0)
                            <span class="btn btn-info btn-sm">Müştəridən cavab gözlənir</span>
                          @elseif($report->report_status == 1)
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
                          <button type="button" data-toggle="modal" data-target="#more_{{$report->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>

                          @if($report->report_status == 1)
                            <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id])}}" class="btn btn-success btn-sm check-confirm-alert"><i class="fa fa-check"></i></a>
                            <a href="{{route('social_reports.cancelRequest',['request_id'=>$report->id])}}" class="btn btn-danger btn-sm confirm-alert"><i class="fa fa-times"></i></a>
                          @elseif($report->report_status == 2 || $report->report_status == 5)
                            <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id])}}" class="btn btn-success btn-sm check-confirm-alert"><i class="fa fa-check"></i></a>
                            <a href="{{route('social_reports.softDeleteRequest',['request_id'=>$report->id])}}" class="btn btn-danger btn-sm delete-confirm-alert"><i class="fa fa-trash"></i></a>
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

  <!--more-->
  @if($reports)
    @foreach ($reports as $key => $report)
      <!-- Modal -->
      <div class="modal fade" id="more_{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="more_label_{{$report->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="more_label_{{$report->id}}">
                Müraciət #{{$report->id}} -

                @if($report->report_status == 0)
                  <span class="btn btn-info btn-sm">Müştəridən cavab gözlənir</span>
                @elseif($report->report_status == 1)
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
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row mt-3">
                <div class="col-md-6">Əlavə olunma tarixi</div>
                <div class="col-md-6">{{$report->created_at}} ({{$report->created_at->diffForHumans()}})</div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">Yenilənmə tarixi</div>
                <div class="col-md-6">{{$report->updated_at}} ({{$report->updated_at->diffForHumans()}})</div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">Sosial şəbəkə</div>
                <div class="col-md-6">
                  @if($report->network_type == 1)
                    Facebook
                  @elseif($report->network_type == 2)
                    Instagram
                  @elseif($report->network_type == 3)
                    Whatsapp
                  @endif
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">Mağaza</div>
                <div class="col-md-6">{{($report->getShop)? $report->getShop->name : ''}}</div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">Məhsul</div>
                <div class="col-md-6">
                  @if($report->product_id)
                    <a target="_blank" href="{{env('PRIMARY_WEB_URL')}}/product/{{$report->product_id}}">#{{$report->product_id}} - {{$report->product_name}}</a>
                  @else
                    {{$report->product_name}}
                  @endif
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">Müştərinin adı</div>
                <div class="col-md-6">{{$report->client_name}}</div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">Əlaqə nömrəsi</div>
                <div class="col-md-6">
                  @if(auth()->user()->role_id != 2)
                  @empty($report->client_contact)
                    <form action="{{route('social_reports.addClientContact',$report->id)}}" method="post">
                      @csrf
                      <div class="input-group">
                        <input type="text" class="form-control" name="client_contact" value="">
                        <div class="input-group-append">
                          <button type="submit" class="input-group-text"><i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                    </form>
                  @endempty
                @endif
                {{$report->client_contact}}
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">Şərhi</div>
              <div class="col-md-6">{{$report->client_comment}}</div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">Avtomobil</div>
              <div class="col-md-6">{{$report->client_auto_car}}</div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">Avtomobilin buraxılış ili</div>
              <div class="col-md-6">{{$report->client_auto_year}}</div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">Avtomobilin Vin kodu (Ban)</div>
              <div class="col-md-6">{{$report->client_auto_vin}}</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>

            @if($report->report_status == 1)
              <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id])}}" class="btn btn-success check-confirm-alert"><i class="fa fa-check"></i> Cavablandı</a>
              <a href="{{route('social_reports.cancelRequest',['request_id'=>$report->id])}}" class="btn btn-danger  confirm-alert"><i class="fa fa-times"></i> İmtina et</a>
            @elseif($report->report_status == 2 || $report->report_status == 5)
              <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id])}}" class="btn btn-success  check-confirm-alert"><i class="fa fa-check"></i> Cavablandı</a>
              <a href="{{route('social_reports.softDeleteRequest',['request_id'=>$report->id])}}" class="btn btn-danger delete-confirm-alert"><i class="fa fa-trash"></i> Sil</a>
            @endif

          </div>
        </div>
      </div>
    </div>
  @endforeach
@endif


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

  $(document).on("click", ".delete-confirm-alert", function(e) {
    e.preventDefault();
    var href = $(this).attr('href');

    bootbox.confirm({
      title: "Silmək",
      message: "Müraciətdən silmək istəyirsiniz?",
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
