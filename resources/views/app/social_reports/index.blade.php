@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Sosial şəbəkə müraciətləri</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          <form class="" action="" method="get">
            <div class="row">
              <div class="col-md-4">

                <div class="form-group">
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
                <select class="select2 form-control" name="shop_id">
                  <option value="">Bütün mağazalar</option>
                  @foreach ($shops as $key => $shop)
                    @if(request()->get('shop_id') == $shop->id)
                      <option value="{{$shop->id}}" selected>{{$shop->name}}</option>
                    @else
                      <option value="{{$shop->id}}">{{$shop->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" name="query" value="{{(request()->get('query')) ? request()->get('query') : ''}}" class="form-control" placeholder="Müştərinin adı və ya nömrəsini daxil edin">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-success form-control"><i class="fa fa-search"></i> Axtar</button>
              </div>
            </div>
          </form>

          @if($reports)
            <div class="row mt-5">
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
                          @if($report->get_report_status)
                            <span class="btn btn-{{$report->get_report_status->color}} btn-sm">{{$report->get_report_status->name}}</span>
                          @endif
                        </td>
                        <td>
                          <button type="button" data-toggle="modal" data-target="#more_{{$report->id}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>

                          @if($report->report_status == 1)
                            <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-success btn-sm check-confirm-alert"><i class="fa fa-check"></i></a>
                            <a href="{{route('social_reports.cancelRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-danger btn-sm confirm-alert"><i class="fa fa-times"></i></a>
                          @elseif($report->report_status == 2 || $report->report_status == 5)
                            <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-success btn-sm check-confirm-alert"><i class="fa fa-check"></i></a>
                            <a href="{{route('social_reports.softDeleteRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-danger btn-sm delete-confirm-alert"><i class="fa fa-trash"></i></a>
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

          @else
            <div class="col-md-12">
              <div class="alert alert-warning">
                Heç bir məlumat tapılmadı
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

                @if($report->get_report_status)
                  <span class="btn btn-{{$report->get_report_status->color}} btn-sm">{{$report->get_report_status->name}}</span>
                @endif

                @if($report->get_report_replies)
                  <span class="btn btn-{{$report->get_report_replies->color}} btn-sm">{{$report->get_report_replies->description}}</span>
                @endif

                @if($report->get_report_cancels)
                  <span class="btn btn-{{$report->get_report_cancels->color}} btn-sm">{{$report->get_report_cancels->description}}</span>
                @endif

              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @if(auth()->user()->role_id != 2)
                @if($report->get_report_status && $report->get_report_status->id == 1 || $report->get_report_status->id == 8)
                  <form class="" action="{{route('social_reports.update',$report->id)}}" method="post">
                    <div class="row mt-3">
                      <div class="col-md-12 text-right"><button type="button" onclick="editReport({{$report->id}});" class="btn btn-primary"><i class="fa fa-edit"></i></button></div>
                    </div>
                  @endif
                @endif

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
                  <div class="col-md-6" id="{{$report->id}}_view_client_name">
                    @if($report->username)
                      @php
                      $social_link = NULL;
                      if($report->network_type == 1){
                        $social_link = $report->username;
                      }elseif($report->network_type == 2){
                        $social_link = 'https://instagram.com/'.$report->username;
                      }
                      @endphp
                      <a target="_blank" href="{{$social_link}}">{{$report->client_name}}</a>
                    @else
                      {{$report->client_name}}
                    @endif
                  </div>
                  <div class="col-md-6" id="{{$report->id}}_edit_client_name" style="display:none;"><input type="text" class="form-control"  name="client_name" value="{{$report->client_name}}"/></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">Əlaqə nömrəsi</div>
                  <div class="col-md-6" id="{{$report->id}}_view_client_contact">{{$report->client_contact}}</div>
                  <div class="col-md-6" id="{{$report->id}}_edit_client_contact" style="display:none;"><input type="text" class="form-control" name="client_contact" value="{{$report->client_contact}}"/></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">Şərhi</div>
                  <div class="col-md-6" id="{{$report->id}}_view_client_comment">{{$report->client_comment}}</div>
                  <div class="col-md-6" id="{{$report->id}}_edit_client_comment" style="display:none;"><input type="text" class="form-control" name="client_comment" value="{{$report->client_comment}}"/></div>

                </div>
                <div class="row mt-3">
                  <div class="col-md-6">Avtomobil</div>
                  <div class="col-md-6" id="{{$report->id}}_view_client_auto_car">{{$report->client_auto_car}}</div>
                  <div class="col-md-6" id="{{$report->id}}_edit_client_auto_car" style="display:none;"><input type="text" class="form-control" name="client_auto_car" value="{{$report->client_auto_car}}"/></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">Avtomobilin buraxılış ili</div>
                  <div class="col-md-6" id="{{$report->id}}_view_client_auto_year">{{$report->client_auto_year}}</div>
                  <div class="col-md-6" id="{{$report->id}}_edit_client_auto_year" style="display:none;"><input type="text" class="form-control" name="client_auto_year" value="{{$report->client_auto_year}}"/></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">Avtomobilin Vin kodu (Ban)</div>
                  <div class="col-md-6" id="{{$report->id}}_view_client_auto_vin">{{$report->client_auto_vin}}</div>
                  <div class="col-md-6" id="{{$report->id}}_edit_client_auto_vin" style="display:none;"><input type="text" class="form-control" name="client_auto_vin" value="{{$report->client_auto_vin}}"/></div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                @if(auth()->user()->role_id != 2)
                  @if($report->get_report_status && $report->get_report_status->id == 1 || $report->get_report_status->id == 8)
                    <button style="display:none" id="{{$report->id}}_save" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Yadda saxla</button>
                    @csrf
                  </form>
                @endif
              @endif

              @if($report->report_status == 1)
                <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-success check-confirm-alert"><i class="fa fa-check"></i> Cavablandı</a>
                <a href="{{route('social_reports.cancelRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-danger  confirm-alert"><i class="fa fa-times"></i> İmtina et</a>
              @elseif($report->report_status == 2 || $report->report_status == 5)
                <a href="{{route('social_reports.confirmRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-success  check-confirm-alert"><i class="fa fa-check"></i> Cavablandı</a>
                <a href="{{route('social_reports.softDeleteRequest',['request_id'=>$report->id,'desc'=>''])}}" class="btn btn-danger delete-confirm-alert"><i class="fa fa-trash"></i> Sil</a>
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

  function editReport(report_id){
    $("#" + report_id +'_view_client_name').hide();
    $("#" + report_id +'_view_client_contact').hide();
    $("#" + report_id +'_view_client_auto_car').hide();
    $("#" + report_id +'_view_client_auto_year').hide();
    $("#" + report_id +'_view_client_auto_vin').hide();
    $("#" + report_id +'_view_client_comment').hide();

    $("#" + report_id+'_edit_client_name').show();
    $("#" + report_id+'_edit_client_contact').show();
    $("#" + report_id+'_edit_client_auto_car').show();
    $("#" + report_id+'_edit_client_auto_year').show();
    $("#" + report_id+'_edit_client_auto_vin').show();
    $("#" + report_id+'_edit_client_comment').show();
    $("#" + report_id+'_save').show();
  }

  function saveReport(report_id){

  }

  $(document).on("click", ".confirm-alert", function(e) {
    e.preventDefault();
    var href = $(this).attr('href');

    bootbox.prompt({
      title: "İmtina etmək",
      message: "İmtina səbəbini seçin",
      buttons: {
        cancel: {
          label: '<i class="fa fa-times"></i> Xeyir'
        },
        confirm: {
          label: '<i class="fa fa-check"></i> Bəli'
        }
      },
      inputType: 'select',
      inputOptions: {!!$cancels->toJson(JSON_UNESCAPED_UNICODE)!!},
      callback: function (result) {
        if(result){
          window.location = href + '/'+ result;
        }
      }
    });
  });

  $(document).on("click", ".delete-confirm-alert", function(e) {
    e.preventDefault();
    var href = $(this).attr('href');

    bootbox.prompt({
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

    bootbox.prompt({
      title: "Təsdiq etmək",
      message: "Nəticəni seçin",
      buttons: {
        cancel: {
          label: '<i class="fa fa-times"></i> Xeyir'
        },
        confirm: {
          label: '<i class="fa fa-check"></i> Bəli'
        }
      },
      inputType: 'select',
      inputOptions: {!!$replies->toJson(JSON_UNESCAPED_UNICODE)!!},
      callback: function (result) {
        if(result){
          window.location = href + '/'+result;
        }
      }
    });
  });

  $('.daterange-cus').daterangepicker({
    locale: {format: 'YYYY-MM-DD'},
    drops: 'down',
    opens: 'right'
  });

  </script>
@endpush
