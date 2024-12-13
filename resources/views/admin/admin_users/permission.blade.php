@extends('admin.template.layout')
@section('content')
@php
//$privileges = \App\Models\UserPrivileges::join('users', 'users.id', 'user_privileges.user_id')
//->join('admin_designation', 'admin_designation.id', '=', 'users.designation_id')->where(['users.id' => $id, 'user_privileges.designation_id' //=> \App\Models\User::where('id', $id)->pluck('designation_id')->first()])->pluck('privileges')->first();




$privileges = \App\Models\UserPrivileges::where('designation_id',$id)->pluck('privileges')->first();

$privileges = json_decode($privileges, true);
@endphp

<style>
    .form-check-label {
      display: block;
      position: relative;
      padding-left: 25px;
      cursor: pointer;
      font-size: 14px;
    }
    .form-check-label input {
      position: absolute !important;
        z-index: -1;
        opacity: 0;
    }
    .control__indicator {
      position: absolute;
      top: 0px;
      /*top: 2px;*/
      left: 0;
      height: 20px;
      width: 20px;
      border-radius: 5px;
      background: #e6e6e6;
    }
    
    .form-check-label:hover input ~ .control__indicator,
    .form-check-label input:focus ~ .control__indicator {
      background: #ccc;
    }
    .form-check-label input:checked ~ .control__indicator {
      background: #CE1126;
    }
    ..form-check-label:hover input:not([disabled]):checked ~ .control__indicator,
    ..form-check-label input:checked:focus ~ .control__indicator {
      background: #0e647d;
    }
    ..form-check-label input:disabled ~ .control__indicator {
      background: #e6e6e6;
      opacity: 0.6;
      pointer-events: none;
    }
    .control__indicator:after {
      
      display: none;
    }
    .form-check-label input:checked ~ .control__indicator:after {
      display: block !important;
      content: '';
      position: absolute;
    }
    .form-check-label .control__indicator:after {
      left: 7px;
      top: 3px;
      width: 6px;
      height: 10px;
      border: solid #fff;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg)
    }
    .form-check-label input:disabled ~ .control__indicator:after {
      border-color: #7b7b7b;
    }
    .btn-outline-success{
        border-radius: 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white !important;
        border: 0 !important;
        background: var(--primary-color) !important;
        background-color: var(--primary-color) !important;
    }
    .btn-outline-warning{
        border-radius: 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white !important;
        border: 0 !important;
        background: var(--secondary-color) !important;
        background-color: var(--secondary-color) !important;
    }
</style>
<div class="card">
   <div class="card-body">
      <div class="col-xs-12 col-sm-12">
         <form method="post" id="admin-form" action="{{ url('admin/save_privilege') }}" enctype="multipart/form-data"
            data-parsley-validate="true">
            <input type="hidden" name="id" value="{{ $id }}">
            @csrf()
            <div class="form-group">
               <fieldset>
                  <legend>Access Rights</legend>
                  
                  
                  <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Users > Customers</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input customers" name="access_groups[customers][View]" @if( isset($privileges['customers']['View']) && $privileges['customers']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input customers" name="access_groups[customers][Create]" @if( isset($privileges['customers']['Create']) && $privileges['customers']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input customers" name="access_groups[customers][Edit]" @if( isset($privileges['customers']['Edit']) && $privileges['customers']['Edit'] == 1 )
                                 checked
                                 @endif value="1" > Edit                                                        <i class="control__indicator"></i></label>
                              </div>

                              <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input customers" name="access_groups[customers][ChangePassword]" @if( isset($privileges['customers']['ChangePassword']) && $privileges['customers']['ChangePassword'] == 1 )
                                checked
                                @endif value="1" > Change Password                                                        <i class="control__indicator"></i></label>
                             </div>


                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input customers" name="access_groups[customers][Delete]" @if( isset($privileges['customers']['Delete']) && $privileges['customers']['Delete'] == 1 )
                                 checked
                                 @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="customers">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="customers">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Inventory > Products</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input products" name="access_groups[products][View]" @if( isset($privileges['products']['View']) && $privileges['products']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input products" name="access_groups[products][Create]" @if( isset($privileges['products']['Create']) && $privileges['products']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>

                             

                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input products" name="access_groups[products][Edit]" @if( isset($privileges['products']['Edit']) && $privileges['products']['Edit'] == 1 )
                                 checked
                                 @endif value="1" > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input products" name="access_groups[products][Delete]" @if( isset($privileges['products']['Delete']) && $privileges['products']['Delete'] == 1 )
                                 checked
                                 @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="products">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="products">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Inventory > Coupon Codes</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input coupon" name="access_groups[coupon][View]" @if( isset($privileges['coupon']['View']) && $privileges['coupon']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input coupon" name="access_groups[coupon][Create]" @if( isset($privileges['coupon']['Create']) && $privileges['coupon']['Create'] == 1 )
                                checked
                                @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input coupon" name="access_groups[coupon][Edit]" @if( isset($privileges['coupon']['Edit']) && $privileges['coupon']['Edit'] == 1 )
                                checked
                                @endif value="1" > Edit                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input coupon" name="access_groups[coupon][Delete]" @if( isset($privileges['coupon']['Delete']) && $privileges['coupon']['Delete'] == 1 )
                                checked
                                @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                             </div>
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="coupon">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="coupon">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>
                  
                  
                  
                  
                 <hr>
                 
                 
                 
              

                 <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Category</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input category" name="access_groups[category][View]" @if( isset($privileges['category']['View']) && $privileges['category']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input category" name="access_groups[category][Create]" @if( isset($privileges['category']['Create']) && $privileges['category']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input category" name="access_groups[category][Edit]" @if( isset($privileges['category']['Edit']) && $privileges['category']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input category" name="access_groups[category][Delete]" @if( isset($privileges['category']['Delete']) && $privileges['category']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="category">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="category">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>

                 <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Product attribute</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input attribute" name="access_groups[attribute][View]" @if( isset($privileges['attribute']['View']) && $privileges['attribute']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input attribute" name="access_groups[attribute][Create]" @if( isset($privileges['attribute']['Create']) && $privileges['attribute']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input attribute" name="access_groups[attribute][Edit]" @if( isset($privileges['attribute']['Edit']) && $privileges['attribute']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input attribute" name="access_groups[attribute][Delete]" @if( isset($privileges['attribute']['Delete']) && $privileges['attribute']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="attribute">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="attribute">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>


                 

                  <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Unit</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input unit" name="access_groups[unit][View]" @if( isset($privileges['unit']['View']) && $privileges['unit']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input unit" name="access_groups[unit][Create]" @if( isset($privileges['unit']['Create']) && $privileges['unit']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input unit" name="access_groups[unit][Edit]" @if( isset($privileges['unit']['Edit']) && $privileges['unit']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input unit" name="access_groups[unit][Delete]" @if( isset($privileges['unit']['Delete']) && $privileges['unit']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="unit">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="unit">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>


                 <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Country</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input country" name="access_groups[country][View]" @if( isset($privileges['country']['View']) && $privileges['unit']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input country" name="access_groups[unit][Create]" @if( isset($privileges['country']['Create']) && $privileges['country']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input country" name="access_groups[country][Edit]" @if( isset($privileges['country']['Edit']) && $privileges['country']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input country" name="access_groups[country][Delete]" @if( isset($privileges['country']['Delete']) && $privileges['country']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="country">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="country">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>

                 <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Emirates /State</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input states" name="access_groups[states][View]" @if( isset($privileges['states']['View']) && $privileges['states']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input states" name="access_groups[states][Create]" @if( isset($privileges['states']['Create']) && $privileges['states']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input states" name="access_groups[states][Edit]" @if( isset($privileges['states']['Edit']) && $privileges['states']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input states" name="access_groups[states][Delete]" @if( isset($privileges['states']['Delete']) && $privileges['states']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="states">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="states">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>

                 <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Area</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input cities" name="access_groups[cities][View]" @if( isset($privileges['cities']['View']) && $privileges['cities']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input cities" name="access_groups[cities][Create]" @if( isset($privileges['cities']['Create']) && $privileges['cities']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input cities" name="access_groups[cities][Edit]" @if( isset($privileges['cities']['Edit']) && $privileges['cities']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input cities" name="access_groups[cities][Delete]" @if( isset($privileges['cities']['Delete']) && $privileges['cities']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="cities">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="cities">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>

                 <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Profile & Certificates</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input instruction_manuals" name="access_groups[instruction_manuals][View]" @if( isset($privileges['instruction_manuals']['View']) && $privileges['instruction_manuals']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input instruction_manuals" name="access_groups[instruction_manuals][Create]" @if( isset($privileges['instruction_manuals']['Create']) && $privileges['instruction_manuals']['Create'] == 1 )
                                 checked
                                 @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input instruction_manuals" name="access_groups[instruction_manuals][Edit]" @if( isset($privileges['instruction_manuals']['Edit']) && $privileges['instruction_manuals']['Edit'] == 1 )
                                 checked
                                 @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                              </div>
                              <div class="form-check form-check-inline mr-5">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input instruction_manuals" name="access_groups[instruction_manuals][Delete]" @if( isset($privileges['instruction_manuals']['Delete']) && $privileges['instruction_manuals']['Delete'] == 1 )
                                 checked
                                 @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                              <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="instruction_manuals">Set All</button>
                              <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="instruction_manuals">Reset</button>
                           </div>
                        </div>
                     </div>
                  </div>
                 <hr>
                 
                  <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Orders</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input orders" name="access_groups[orders][View]" @if( isset($privileges['orders']['View']) && $privileges['orders']['View'] == 1 )
                                 checked
                                 @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                              </div>

                              <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input orders" name="access_groups[orders][Details]" @if( isset($privileges['orders']['Details']) && $privileges['orders']['Details'] == 1 )
                                checked
                                @endif value="1" > Details                                                        <i class="control__indicator"></i></label>
                             </div>

                           </div>
                           <div class="col-3 pt-1">
                            <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="orders">Set All</button>
                            <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="orders">Reset</button>
                         </div>
                        </div>
                     </div>
                  </div>
                 <hr>

                     

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">CMS Pages</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cms" name="access_groups[cms][View]" @if( isset($privileges['cms']['View']) && $privileges['cms']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cms" name="access_groups[cms][Create]" @if( isset($privileges['cms']['Create']) && $privileges['cms']['Create'] == 1 )
                                checked
                                @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cms" name="access_groups[cms][Edit]" @if( isset($privileges['cms']['Edit']) && $privileges['cms']['Edit'] == 1 )
                                checked
                                @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input cms" name="access_groups[cms][Delete]" @if( isset($privileges['cms']['Delete']) && $privileges['cms']['Delete'] == 1 )
                                checked
                                @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                             </div>
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="cms">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="cms">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>
                 <hr>      
                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">FAQ</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input faq" name="access_groups[faq][View]" @if( isset($privileges['faq']['View']) && $privileges['faq']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input faq" name="access_groups[faq][Create]" @if( isset($privileges['faq']['Create']) && $privileges['faq']['Create'] == 1 )
                                checked
                                @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input faq" name="access_groups[faq][Edit]" @if( isset($privileges['faq']['Edit']) && $privileges['faq']['Edit'] == 1 )
                                checked
                                @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input faq" name="access_groups[faq][Delete]" @if( isset($privileges['faq']['Delete']) && $privileges['faq']['Delete'] == 1 )
                                checked
                                @endif value="1"  > Delete                                                        <i class="control__indicator"></i></label>
                             </div>
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="faq">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="faq">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>
                 <hr>   

                    
                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Contact settings</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input contact_settings" name="access_groups[contact_settings][View]" @if( isset($privileges['contact_settings']['View']) && $privileges['contact_settings']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                            
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input contact_settings" name="access_groups[contact_settings][Edit]" @if( isset($privileges['contact_settings']['Edit']) && $privileges['contact_settings']['Edit'] == 1 )
                                checked
                                @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                             </div>
                           
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="contact_settings">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="contact_settings">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>
                 <hr>      

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Settings</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input settings" name="access_groups[settings][View]" @if( isset($privileges['settings']['View']) && $privileges['settings']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                             
                             <div class="form-check form-check-inline mr-5">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input settings" name="access_groups[settings][Edit]" @if( isset($privileges['settings']['Edit']) && $privileges['settings']['Edit'] == 1 )
                                checked
                                @endif value="1"  > Edit                                                        <i class="control__indicator"></i></label>
                             </div>
                            
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="settings">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="settings">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>
                 <hr>                 
                 
                 
               

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Reports - Users</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input reportusers" name="access_groups[reportusers][View]" @if( isset($privileges['reportusers']['View']) && $privileges['reportusers']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="reportusers">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="reportusers">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>

                 <hr>  

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Reports - Orders</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input reportorders" name="access_groups[reportorders][View]" @if( isset($privileges['reportorders']['View']) && $privileges['reportorders']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="reportorders">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="reportorders">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>

                 <hr>  

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Reports - Top selling</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input topselling" name="access_groups[topselling][View]" @if( isset($privileges['topselling']['View']) && $privileges['topselling']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="topselling">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="topselling">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>

                 <hr>  

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">App Banners</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input app_banners" name="access_groups[app_banners][View]" @if( isset($privileges['app_banners']['View']) && $privileges['app_banners']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                              <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input app_banners" name="access_groups[app_banners][Edit]" @if( isset($privileges['app_banners']['Edit']) && $privileges['app_banners']['Edit'] == 1 )
                                checked
                                @endif value="1" > Edit                                                        <i class="control__indicator"></i></label>
                             </div>
                              <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input app_banners" name="access_groups[app_banners][Delete]" @if( isset($privileges['app_banners']['Delete']) && $privileges['app_banners']['Delete'] == 1 )
                                checked
                                @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                             </div>

                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="app_banners">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="app_banners">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>

                 <hr>                 
                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Ad Banners</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input ad_banners" name="access_groups[ad_banners][View]" @if( isset($privileges['ad_banners']['View']) && $privileges['ad_banners']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input ad_banners" name="access_groups[ad_banners][Edit]" @if( isset($privileges['ad_banners']['Edit']) && $privileges['ad_banners']['Edit'] == 1 )
                                checked
                                @endif value="1" > Edit                                                        <i class="control__indicator"></i></label>
                             </div>

                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input ad_banners" name="access_groups[ad_banners][Delete]" @if( isset($privileges['ad_banners']['Delete']) && $privileges['ad_banners']['Delete'] == 1 )
                                checked
                                @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                             </div>

                          </div>
                          <div class="col-3 pt-1">
                             <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="ad_banners">Set All</button>
                             <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="ad_banners">Reset</button>
                          </div>
                       </div>
                    </div>
                 </div>

                 <hr>                 
                 
                 

                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Testimonials</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input testimonials" name="access_groups[testimonials][View]" @if( isset($privileges['testimonials']['View']) && $privileges['testimonials']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>

                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input testimonials" name="access_groups[testimonials][Create]" @if( isset($privileges['testimonials']['Create']) && $privileges['testimonials']['Create'] == 1 )
                                checked
                                @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                             </div>
                 
                             <div class="form-check form-check-inline mr-4 mt-3">
                               <label class="form-check-label">
                               <input type="checkbox" class="form-check-input testimonials" name="access_groups[testimonials][Delete]" @if( isset($privileges['testimonials']['Delete']) && $privileges['testimonials']['Delete'] == 1 )
                               checked
                               @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                            </div>
                          </div>
                          <div class="col-3 pt-1">
                            <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="testimonials">Set All</button>
                            <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="testimonials">Reset</button>
                         </div>
                       </div>
                    </div>
                 </div>

                 <hr>                 
                                  
                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Ratings</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input rating" name="access_groups[rating][View]" @if( isset($privileges['rating']['View']) && $privileges['rating']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>

                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input rating" name="access_groups[rating][Edit]" @if( isset($privileges['rating']['Edit']) && $privileges['rating']['Edit'] == 1 )
                                checked
                                @endif value="1" > Edit                                                        <i class="control__indicator"></i></label>
                             </div>

                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input rating" name="access_groups[rating][View]" @if( isset($privileges['rating']['View']) && $privileges['rating']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>
                 
                             <div class="form-check form-check-inline mr-4 mt-3">
                               <label class="form-check-label">
                               <input type="checkbox" class="form-check-input rating" name="access_groups[rating][Delete]" @if( isset($privileges['rating']['Delete']) && $privileges['rating']['Delete'] == 1 )
                               checked
                               @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                            </div>
                          </div>
                          <div class="col-3 pt-1">
                            <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="rating">Set All</button>
                            <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="rating">Reset</button>
                         </div>
                       </div>
                    </div>
                 </div>

                 <hr>                 
                                  
                 <div class="form-group row mt-0 mb-0">
                    <label class="col-sm-2 col-form-label px-0 mt-2">Notification</label>
                    <div class="col-sm-10 px-0">
                       <div class="row">
                          <div class="col-9" role="access-group-row">
                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input notifications" name="access_groups[notification][View]" @if( isset($privileges['notification']['View']) && $privileges['notification']['View'] == 1 )
                                checked
                                @endif value="1" > View                                                        <i class="control__indicator"></i></label>
                             </div>

                             <div class="form-check form-check-inline mr-4 mt-3">
                                <label class="form-check-label">
                                <input type="checkbox" class="form-check-input notifications" name="access_groups[notification][Create]" @if( isset($privileges['notification']['Create']) && $privileges['notification']['Create'] == 1 )
                                checked
                                @endif value="1" > Create                                                        <i class="control__indicator"></i></label>
                             </div>
                 
                             <div class="form-check form-check-inline mr-4 mt-3">
                               <label class="form-check-label">
                               <input type="checkbox" class="form-check-input notifications" name="access_groups[notification][Delete]" @if( isset($privileges['notification']['Delete']) && $privileges['notification']['Delete'] == 1 )
                               checked
                               @endif value="1" > Delete                                                        <i class="control__indicator"></i></label>
                            </div>
                          </div>
                          <div class="col-3 pt-1">
                            <button type="button" class="btn btn-mini btn-outline-success" role="access-set-all" target="notifications">Set All</button>
                            <button type="button" class="btn btn-mini btn-outline-warning ml-2" role="access-reset-all" target="notifications">Reset</button>
                         </div>
                       </div>
                    </div>
                 </div>
                  
                  {{-- <div class="form-group row mt-0 mb-0">
                     <label class="col-sm-2 col-form-label px-0 mt-2">Reports</label>
                     <div class="col-sm-10 px-0">
                        <div class="row">
                           <div class="col-9" role="access-group-row">
                              <div class="form-check form-check-inline mr-4 mt-3">
                                 <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input" name="access_groups[report][View]" value="1" @if( isset($privileges['report']['View']) && $privileges['report']['View'] == 1 )
                                 checked
                                 @endif data-parsley-multiple="access_groups1041" > View                                                        <i class="control__indicator"></i></label>
                              </div>
                           </div>
                           <div class="col-3 pt-1">
                           </div>
                        </div>
                     </div>
                  </div> --}}
               </fieldset>
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-primary">Submit</button>
            </div>
         </form>
      </div>
      <div class="col-xs-12 col-sm-6">
      </div>
   </div>
</div>
@stop
@section('script')
<script>
   App.initFormView();
   $('body').off('submit', '#admin-form');
   $('body').on('submit', '#admin-form', function(e) {
       e.preventDefault();
       var $form = $(this);
       var formData = new FormData(this);
       $(".invalid-feedback").remove();
   
       App.loading(true);
       $form.find('button[type="submit"]')
           .text('Saving')
           .attr('disabled', true);
   
       $.ajax({
           type: "POST",
           enctype: 'multipart/form-data',
           url: $form.attr('action'),
           data: formData,
           processData: false,
           contentType: false,
           cache: false,
           dataType: 'json',
           timeout: 600000,
           success: function(res) {
               App.loading(false);
   
               if (res['status'] == 0) {
                   if (typeof res['errors'] !== 'undefined') {
                       var error_def = $.Deferred();
                       var error_index = 0;
                       jQuery.each(res['errors'], function(e_field, e_message) {
                           if (e_message != '') {
                               $('[name="' + e_field + '"]').eq(0).addClass('is-invalid');
                               $('<div class="invalid-feedback">' + e_message + '</div>')
                                   .insertAfter($('[name="' + e_field + '"]').eq(0));
                               if (error_index == 0) {
                                   error_def.resolve();
                               }
                               error_index++;
                           }
                       });
                       error_def.done(function() {
                           var error = $form.find('.is-invalid').eq(0);
                           $('html, body').animate({
                               scrollTop: (error.offset().top - 100),
                           }, 500);
                       });
                   } else {
                       var m = res['message'];
                       App.alert(m, 'Oops!');
                   }
               } else {
                   App.alert(res['message']);
                   setTimeout(function() {
                       window.location.href = App.siteUrl('/admin/admin_users/update_permission/{{ $id }}');
                   }, 1500);
               }
   
               $form.find('button[type="submit"]')
                   .text('Save')
                   .attr('disabled', false);
           },
           error: function(e) {
               App.loading(false);
               $form.find('button[type="submit"]')
                   .text('Save')
                   .attr('disabled', false);
               App.alert(e.responseText, 'Oops!');
           }
       });
   });
   $('body').off('click', '[role="access-set-all"]');
   $('body').on('click', '[role="access-set-all"]', function(e) {
       var traget = $(this).attr('target');
       $('.'+traget).attr('checked', 'checked');
   });
   $('body').off('click', '[role="access-reset-all"]');
   $('body').on('click', '[role="access-reset-all"]', function(e) {
       var traget = $(this).attr('target');
       $('.'+traget).attr('checked', false);
   });
</script>
@stop