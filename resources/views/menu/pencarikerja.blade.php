<br>
<br>
<!-- Listing Section -->
<section class="ls-section">
   <div class="auto-container">
     <div class="filters-backdrop"></div>

     <div class="row">

       <!-- Filters Column -->
       <div class="filters-column col-lg-4 col-md-12 col-sm-12">
         <form>
         <div class="inner-column">
           <div class="filters-outer">
             <button type="button" class="theme-btn close-filters">X</button>

             <!-- Filter Block -->
             <div class="filter-block">
               <h4>Cari Dengan Kata Kunci</h4>
               <div class="form-group">
                 <input type="text" name="search" id="judul" value="{{$parameter['search'] ?? ''}}" placeholder="Job title, keywords, or company">
                 <span class="icon flaticon-search-3"></span>
               </div>
             </div>

             <!-- Filter Block -->
             <div class="filter-block">
               <h4>Lokasi</h4>
               <label>Kecamatan</label>
               <div class="form-group">
                   {!!Sideveloper::formSelect(null, $kecamatan_option, 'id_kecamatan', $parameter['id_kecamatan'] ?? '')!!}
                   <span class="icon flaticon-map-locator"></span>
               </div>
               <label>Kelurahan</label>
               <div class="form-group">
                   {!!Sideveloper::formSelect(null, null, 'id_kelurahan', null, false, '')!!}
                   <span class="icon flaticon-map-locator"></span>
               </div>
             </div>

             <!-- Filter Block -->
             <div class="filter-block">
               <h4>Keahlian</h4>
               <div class="form-group">
                   {!!Sideveloper::formSelect(null, $keahlian_option, 'id_keahlian', $parameter['id_keahlian'] ?? '')!!}
                   <span class="icon flaticon-briefcase"></span>
               </div>
             </div>

             <!-- Filter Block -->
             <div class="filter-block">
               <h4>Bahasa</h4>
               <div class="form-group">
                   {!!Sideveloper::formSelect(null, $bahasa_option, 'id_bahasa', $parameter['id_bahasa'] ?? '')!!}
                   <span class="icon flaticon-chat"></span>
               </div>
             </div>

             <!-- Checkboxes Ouer -->
             <div class="checkbox-outer">
               <h4>Pendidikan Terakhir</h4>
               <ul class="checkboxes">
                   @foreach($pendidikan as $jp)
                   <li>
                       <input type="checkbox" id="jp-{{$jp->id}}"
                       @if(@in_array($jp->id, @$parameter['pendidikan']))
                       checked
                       @endif
                       name="pendidikan[]" value="{{$jp->id}}">
                       <label for="jp-{{$jp->id}}">{{$jp->nama}}</label>
                   </li>
                   @endforeach
               </ul>
             </div>
             <button class="btn btn-info" type="submit" style="color: white; width:100%; margin-bottom:15px;">FILTER</button>
           </div>
         </div>
         </form>
       </div>

       <!-- Content Column -->
       <div class="content-column col-lg-8 col-md-12 col-sm-12">
         <div class="ls-outer">

            <!-- ls Switcher -->
            <div class="ls-switcher">
               <div class="showing-result">
                 <div class="text"><strong>{{$data->firstItem()}}-{{$data->lastItem()}}</strong> dari <strong>{{$data->total()}}</strong> Pencari Kerja</div>
               </div>
           </div>
           @foreach($data as $d)
           <!-- Job Block -->
           <div onclick="location.href='{{url('menu/pencarikerja-detil?id='.$d->id_profil)}}';" style="cursor: pointer;" class="job-block">
             <div class="inner-box">
               <div class="content">
                 <span class="company-logo"><img src="{{Sideveloper::storageUrl($d->foto)}}" alt=""></span>
                 <h4><a href="{{url('menu/pencarikerja-detil?id='.$d->id_profil)}}">{{$d->nama}}</a></h4>
                 <ul class="job-info">
                    <li class="designation" style="padding-left: 0px;color: #1967D2;">Sarjana - Teknik Informatika</li>
                   <li><span class="icon flaticon-map-locator"></span> {{$d->kecamatan}}, {{$d->kelurahan}}</li>
                   <li><span class="icon flaticon-clock-3"></span> Terdaftar pada {{Sideveloper::date($d->created_date)}}</li>
                   {{-- <li><span class="icon flaticon-money"></span> {{Sideveloper::gaji_show($d)}}</li> --}}
                 </ul>
                 <ul class="job-other-info">
                    @foreach(DB::table('vchoice_pencari_kerja')->where('id_tipe','2')->where('id_user', $d->id_user)->get() as $ch)
                    <li class="time">{{$ch->nama_choice}}</li>
                    @endforeach
                   {{-- <li class="{{$d->class_jenis}}">{{$d->jenis_pekerjaan}}</li>
                   <li class="required">Min. {{$d->pendidikan}}</li> --}}
                 </ul>
                 <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
               </div>
             </div>
           </div>
           @endforeach
           <div style="position: relative">
               {{$data->appends($parameter)->links()}}
           </div>
           {{-- <nav class="ls-pagination">
               <ul>
                 <li class="prev"><a href="#"><i class="fa fa-arrow-left"></i></a></li>
                 <li><a href="#">1</a></li>
                 <li><a href="#" class="current-page">2</a></li>
                 <li><a href="#">3</a></li>
                 <li class="next"><a href="#"><i class="fa fa-arrow-right"></i></a></li>
               </ul>
           </nav> --}}
         </div>
       </div>
     </div>
   </div>
 </section>
 <!--End Listing Page Section -->

 <script>
   $(document).ready(function(){
       getKelurahan("{{$parameter['id_kecamatan'] ?? ''}}");
   });
   $("#id_kecamatan").change(function(){
       getKelurahan();
   });
   function getKelurahan(defaultvalue = '', next = '', next2 = ''){
       var tag  = $("#id_kelurahan");
       var url  = "{{url('option')}}";
       var data = {
           search: 'kelurahaan',
           id    : $("#id_kecamatan").val(),
           all : 'true',
       };
       getOption(tag, url, data, null, defaultvalue);
   }
 </script>