@extends("admin.template.layout")

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

              <!-- Ajax Sourced Server-side -->
              <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                   <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
                
              </div>
              <div class="card-body">
              <div class="card-datatable text-nowrap">
                  <div class="table-responsive">
                     <table class="datatables-ajax table table-condensed" data-role="ui-datatable" data-src="{{route('getReviewList')}}" >
                       <thead>
                           <tr>
                               <th class="pt-0" data-colname="id">#</th>
                               <th class="pt-0" data-colname="booking_id">Booking Number</th>
                               <th class="pt-0" data-colname="comment">Comment</th>
                               <th class="pt-0" data-colname="rate">Rate</th>
                               <th class="pt-0" data-colname="status">Status</th>
                               <th class="pt-0" data-colname="updated_by">Updated By</th>
                               <th class="pt-0" data-colname="created_at">Created on</th>
                               <th class="pt-0" data-colname="action">Action</th>
                           </tr>
                       </thead>
                       <tbody>
                            <tbody>
                    
                       </tbody>
                     </table>
                      
             </div>
              </div>
              </div>
              </div>
              <!--/ Ajax Sourced Server-side -->

 <!-- <div class="card"> -->
   <!-- <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">List</h5>
   </div> -->
   <!-- <div class="card-body">
      <div class="card-datatable text-nowrap">
         <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"> -->
               <!-- <div class="dataTables_length" id="DataTables_Table_0_length">
                  <label>
                     Show 
                     <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                     </select>
                     entries
                  </label>
               </div> -->
               <!-- <div id="DataTables_Table_0_processing" class="dataTables_processing" role="status" style="display: none;">
                  <div>
                     <div></div>
                     <div></div>
                     <div></div>
                     <div></div>
                  </div>
               </div> -->
               <!-- <table class="datatables-ajax table table-condensed dataTable no-footer" data-role="ui-datatable" data-src="https://dxbitprojects.com/timex_web/public/admin/reviews/list" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                  <thead>
                     <tr>
                        <th class="pt-0 sorting sorting_desc" data-colname="id" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="#: activate to sort column ascending">#</th>
                        <th class="pt-0 sorting" data-colname="booking_id" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Booking Number: activate to sort column ascending">Booking Number</th>
                        <th class="pt-0 sorting" data-colname="comment" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Comment: activate to sort column ascending">Comment</th>
                        <th class="pt-0 sorting" data-colname="rate" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Rate: activate to sort column ascending">Rate</th>
                        <th class="pt-0 sorting" data-colname="status" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                        <th class="pt-0 sorting" data-colname="updated_by" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Updated By: activate to sort column ascending">Updated By</th>
                        <th class="pt-0 sorting" data-colname="created_at" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Created on: activate to sort column ascending">Created on</th>
                        <th class="pt-0 sorting" data-colname="action" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr class="odd">
                        <td class="sorting_1">1</td>
                        <td>#TX-000309</td>
                        <td>Best Service</td>
                        <td>
                           <div class="star-rating">
                               5 
                               <div class="starts">
                                   <i class="fa fa-star"></i>
                                   <i class="fa fa-star"></i>
                                   <i class="fa fa-star"></i>
                                   <i class="fa fa-star"></i>
                                   <i class="fa fa-star"></i>
                               </div>
                           </div>
                            
                        </td>
                        <td><span class="badge badge-secondary"> Pending </span></td>
                        <td></td>
                        <td>16/11/23 01:46 PM</td>
                        <td>
                           <div class="dropdown custom-dropdown">
                              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              <i class="flaticon-dot-three"></i>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7"><a class="dropdown-item" href="https://dxbitprojects.com/timex_web/public/admin/reviews/edit/eyJpdiI6IktnemFHcWFpUlk2bEwrS2g0bXVGNVE9PSIsInZhbHVlIjoiZzN1dE40aFJOM3RiRzdWQmJMUG56UT09IiwibWFjIjoiM2IwZDZlY2M1MDljNGU1ZmFhZTdmYjM0MWQ5MGM0YWYzZjhiZDQ2MDk5MmQ3M2FjYmZiMjdmYTc5ZmIzYjU4YiIsInRhZyI6IiJ9"><i class="flaticon-pencil-1"></i> Edit</a><a class="dropdown-item" data-role="unlink" data-message="Do you want to remove this review?" href="https://dxbitprojects.com/timex_web/public/admin/reviews/delete/eyJpdiI6IlZidWk0WEZULys3a29nQTFpcmU4V3c9PSIsInZhbHVlIjoiQ0R0Y2l1dnFQSi9SempBY2NnZ0J0dz09IiwibWFjIjoiZjA2YmE0YTliNDJlYzkzMWEyZDUyY2MyMDQ1YTFjYjgwMTA4NmZiNGQwNGJlNDIxMjBjYTY3OGM1ZTQ1MmE5MCIsInRhZyI6IiJ9"><i class="flaticon-delete-1"></i> Delete</a></div>
                           </div>
                        </td>
                     </tr>
                     <tr class="even">
                        <td class="sorting_1">2</td>
                        <td>#TX-000247</td>
                        <td>toke call me at the moment and your</td>
                        <td>
                            <div class="star-rating">
                              3.5
                               <div class="starts">
                                   <i class="fa fa-star"></i>
                                   <i class="fa fa-star"></i>
                                   <i class="fa fa-star"></i>
                                   half star 
                                    <i class="fa-solid fa-star-half-stroke"></i> 
                                    empty star
                                     <i class="fa-regular fa-star"></i>
                                
                               </div>
                           </div>
                            
                            
                        </td>
                        <td><span class="badge badge-success"> Approved </span></td>
                        <td>Admin</td>
                        <td>14/11/23 01:58 PM</td>
                        <td>
                           <div class="dropdown custom-dropdown">
                              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              <i class="flaticon-dot-three"></i>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink7"><a class="dropdown-item" href="https://dxbitprojects.com/timex_web/public/admin/reviews/edit/eyJpdiI6InhhY1BZVzZOM2s0N3dPRW9xMXZteEE9PSIsInZhbHVlIjoiT3lVN09FZ3NKaWFUZ2F6aXd3cGVDdz09IiwibWFjIjoiZmI4NzgyOTQ4YTZiNTY4MmQwM2VlZDU4MjZiMWVmYzViNjg0NDJkYWY1OTdiMjA0ZGQ5ZmYxYzM0MDVlYTQwMyIsInRhZyI6IiJ9"><i class="flaticon-pencil-1"></i> Edit</a><a class="dropdown-item" data-role="unlink" data-message="Do you want to remove this review?" href="https://dxbitprojects.com/timex_web/public/admin/reviews/delete/eyJpdiI6IitPWlFwb2RxYkROb0ROMFArQlhDVEE9PSIsInZhbHVlIjoiL3Q1MkFiR0crdUhyWUgvM2JSUmlZdz09IiwibWFjIjoiN2M0ZTI0ZjZiNmJjM2QwMGMxNjA1MTc5ZjFkNDA1OGVmNzM3Zjg4NjA1MThkOTFkMDMyODcxYzA0MTRjMTIzNiIsInRhZyI6IiJ9"><i class="flaticon-delete-1"></i> Delete</a></div>
                           </div>
                        </td>
                     </tr>
                  </tbody>
               </table> -->
               <!-- <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 15 entries</div>
               <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button first disabled" aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link" data-dt-idx="first" tabindex="-1" id="DataTables_Table_0_first">First</a><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" aria-disabled="true" aria-role="link" data-dt-idx="previous" tabindex="-1" id="DataTables_Table_0_previous">Previous</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" aria-role="link" aria-current="page" data-dt-idx="0" tabindex="0">1</a><a class="paginate_button " aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="1" tabindex="0">2</a></span><a class="paginate_button next" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="next" tabindex="0" id="DataTables_Table_0_next">Next</a><a class="paginate_button last" aria-controls="DataTables_Table_0" aria-role="link" data-dt-idx="last" tabindex="0" id="DataTables_Table_0_last">Last</a></div>
            </div>
         </div>
      </div>
   </div>
</div> -->




            </div>
            <style>
                .star-rating{
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    flex-direction: row;
                    font-weight:bold;
                }
                .star-rating .starts{
                    color: #FF9800;
                }
            </style>
@stop
@section('script')
<script>
  jQuery(document).ready(function(){

      App.initTreeView();

  })
</script>
@stop
