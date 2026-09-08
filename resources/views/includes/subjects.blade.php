      <div class="row">
        <div style="padding-bottom: 20px;">
           <h2 class="text-center fw-semibold">Services at  <span class="text-primary"> {{ domain_name() }} </span></h2> 
        </div>


        <?php
        $posts = \App\Models\Category::orderBy('display_name', 'asc')->get();
        ?>

        @foreach($posts as $post)


        <div class="col-lg-4 col-xl-4 col-md-8 col-sm-12">
          <a href="">

             <div>
                <a href="{{ url('/') }}/service/{{ $post->category_slug }}">
                 <p>{{ $post->display_name }}</p>   
               </a>
             </div>
          </a>
     </div>

     @endforeach
   </div>