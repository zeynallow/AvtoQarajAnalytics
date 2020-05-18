
function categoryTrack(category_id){
  aqTrackingSend('api/categoryTrack/category',{category_id:category_id});
}

function routeTrack(route){
  aqTrackingSend('api/routeTrack/route',{route:route});
}

function productTrack(product_id,shop_id){
  aqTrackingSend('api/productTrack/product',{product_id:product_id,shop_id:shop_id});
}

function shopTrack(shop_id){
  aqTrackingSend('api/shopTrack/shop',{shop_id:shop_id});
}

function shopCategoryTrack(category_id,shop_id){
  aqTrackingSend('api/shopTrack/shop_category',{category_id:category_id,shop_id:shop_id});
}

function carSearchTrack(car_type_id,car_make_id,car_model_id,car_generation_id){
  aqTrackingSend('api/carSearchTrack/car_search',{
    car_type_id:car_type_id,
    car_make_id:car_make_id,
    car_model_id:car_model_id,
    car_generation_id:car_generation_id
  });
}

function aqTrackingSend(endpoint,data){
  var aq_tracking_url = 'https://analytics.avtoqaraj.az/';

  setTimeout(function(){
    $.ajax({
      type: 'post',
      dataType: 'JSON',
      url: aq_tracking_url + '/'+ endpoint,
      data:data,
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(JSON.stringify(xhr.responseText));
      }
    });
  }, 1000);

}
