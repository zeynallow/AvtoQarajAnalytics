@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Test</h1>
    </div>
    <div class="section-body">

      <div class="">
        salam
      </div>

    </div>
  </section>
@endsection
@push('javascript')
  <script type="text/javascript" src="/js/aqtracking.js"></script>
  <script type="text/javascript">
  /* aqTrack */
  // var aq_category_track_id = 55;
  // categoryTrack(aq_category_track_id);
  /* aqTrack end */

  /* aqTrack */
  // var aq_route_track = '{{request()->path()}}';
  // routeTrack(aq_route_track);
  /* aqTrack end */

  /* aqTrack */
  // var aq_product_track_id = 40;
  // var aq_product_shop_track_id = 40;
  // productTrack(aq_product_track_id,aq_product_shop_track_id);
  /* aqTrack end */

  /* aqTrack */
  // var aq_shop_id = 20;
  // shopTrack(aq_shop_id);
  /* aqTrack end */

  /* aqTrack */
  // var aq_shop_category_track_id = 55;
  // var aq_shop_category_shop_id = 20;
  // shopCategoryTrack(aq_shop_category_track_id,aq_shop_category_shop_id);
  /* aqTrack end */

  /* aqTrack */
  // var aq_search_car_type_id = 15;
  // var aq_search_car_make_id = 25;
  // var aq_search_car_model_id = 35;
  // var aq_search_car_generation_id = 45;
  // carSearchTrack(aq_search_car_type_id,aq_search_car_make_id,aq_search_car_model_id,aq_search_car_generation_id);
  /* aqTrack end */

  </script>
@endpush
