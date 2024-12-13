<div class="row">
  @if(!empty($datamain) && count($datamain) > 0)
     <div class="col-md-6 mb-2" id = "collection_address_div" style="border-right: 1px solid #f9f9f9;">
      <label class="form-label" for="coll_label">Collection Address</label>
      <!--<table width="100%">-->
      <!--  <tr>-->
      <!--  @foreach($datamain as $key=>$addres)-->
      <!--  <td><input type="radio" name="collection_address_id" id="coll_label"  required value="{{$addres->id}}"></td>-->
      <!--  <td>{{$addres->address}}</td>-->
      <!--  @endforeach-->
      <!-- </tr>-->
      <!--</table>-->
      
        <div class="wrapper carousel_wrapper carousel_wrapper1 position-relative">
          <div class="collectionaddress address_carousel">
              @foreach($datamain as $key=>$addres)
            <div>
                <div class="address-list-slider">
                    <input type="radio" name="collection_address_id" id="coll_label"  required value="{{$addres->id}}"> 
                    <h6>{{$addres->address}}</h6>
                </div>
            </div>
            @endforeach
          </div>
          <ul>
                <li class="prev"><i class="bx bx-chevron-left"></i></li>
                <li class="next"><i class="bx bx-chevron-right"></i></li>
            </ul>
        </div>
                                  
                                    </div>

                                    <div class="col-md-6 mb-2" id = "deliver_address_div">
                                    <label class="form-label" for="deliv_label">Deliver Address</label>
      <!--                              <table width="100%">-->
      <!--  <tr>-->
      <!--  @foreach($datamain as $key=>$addres)-->
      <!--  <td><input type="radio" name="deliver_address_id"  id="deliv_label" value="{{$addres->id}}"></td>-->
      <!--  <td>{{$addres->address}}</td>-->
      <!--  @endforeach-->
      <!-- </tr>-->
      <!--</table>-->
      
      <div class="wrapper carousel_wrapper position-relative">
          <div class="deliveraddress address_carousel">
              @foreach($datamain as $key=>$addres)
            <div>
                <div class="address-list-slider">
                    <input type="radio" name="deliver_address_id"  id="deliv_label" value="{{$addres->id}}"></td>
                    <h6>{{$addres->address}}</h6>
                </div>
            </div>
            @endforeach
          </div>
          <ul>
                <li class="prev1"><i class="bx bx-chevron-left"></i></li>
                <li class="next1"><i class="bx bx-chevron-right"></i></li>
            </ul>
        </div>
                                    </div>
                                  @else
                                  <div class="col-md-6 mb-3">
                                  <font color="red">No address found for selected user!</font>
</div>
                                @endif </div>