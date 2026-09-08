@extends('theme.perfectwriter.header')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description') @if( ! empty(get_option(site_id().'_show_5_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_5_meta')))),0,160) }}@endif @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('perfectwriter/css/blog-page.css')}}">
<section class="blogPage">
  <div class="blogTitle">
    <h1 data-aos-duration="800" data-aos-delay="200" data-aos="fade-up">{{ domain_name()}} - Help Me Write My Essay</h1>
    <div class="titlePara">
      <p data-aos-duration="800" data-aos-delay="200" data-aos="fade-up" class="des-head">
      Do you wonder how you will write an essay? Don't worry! You've come to the right spot. You will find everything you need here, from research paper templates to essay guides. ! </p> 
      <!-- <p data-aos-duration="800" data-aos-delay="200" data-aos="fade-up" class="des-head"> </p> -->
    </div> 

 

    <div id="search-body" class="search-body">
      <div class="searchWraper" data-aos-duration="800" data-aos-delay="200" data-aos="fade-up">

        <input type="text" id="filter" class="searchControl" placeholder="Searching.....">
        <span class="searchIcon">
          <svg width="32" height="32" viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="16" fill="#117BD4"></rect>
            <g clip-path="url(#clip0_4872_288)">
              <path d="M14.6346 20.2642C15.8859 20.2642 17.1014 19.8467 18.0887 19.0778L21.8131 22.8022C22.0913 23.0709 22.5347 23.0632 22.8034 22.785C23.0655 22.5136 23.0655 22.0833 22.8034 21.812L19.0789 18.0875C20.987 15.6314 20.5427 12.0935 18.0865 10.1855C15.6304 8.27745 12.0925 8.72177 10.1845 11.1779C8.27648 13.6341 8.72079 17.1719 11.1769 19.08C12.1658 19.8481 13.3824 20.2648 14.6346 20.2642ZM11.642 11.6408C13.2948 9.98803 15.9744 9.988 17.6272 11.6408C19.28 13.2935 19.28 15.9732 17.6273 17.626C15.9745 19.2788 13.2949 19.2788 11.6421 17.626C11.642 17.626 11.642 17.626 11.642 17.626C9.98924 15.9853 9.9795 13.3154 11.6202 11.6626C11.6275 11.6553 11.6347 11.6481 11.642 11.6408Z" fill="white"></path>
            </g>
            <defs>
              <clippath id="clip0_4872_288">
                <rect width="14" height="14" fill="white" transform="translate(9 9)"></rect>
              </clippath>
            </defs>
          </svg>
        </span>
      </div>
    </div>



  </div>
      <!-- <div class="blogSearch">
        <input type="text" placeholder="Search for a topic" />
      </div> -->

      <div class="container">
        <div class="blogtop">
          <link rel="stylesheet" href="{{ asset('perfectwriter/includes/dynamicPages/dynamic-blogs-listing/css/listing.css')}}">
          <script>
            $(function(){
              $('.noResultFound').hide();
              $("#filter").keyup(function() {
                console.log('filter')
// Retrieve the input field text and reset the count to zero
var filter = $(this).val(),
count = 0;

  // Highlight a Text
  let listItems = $(".blogName h2 a");
  listItems.each(function() {
    let itemText = $(this).text();
    let regex = new RegExp(filter, "gi");

    if (filter.length > 0 && itemText.match(regex)) {
      $(this).html(itemText.replace(regex, `<span class="highlight">$&</span>`));
    } else {
      $(this).html(itemText);
    }
  });
  // Highlight a End
  
  $('.blogList .blog').each(function() {

  // If the list item does not contain the text phrase fade it out
  if ($(this).text().search(new RegExp(filter, "i")) < 0) {

    $(this).hide();
    // Show the list item if the phrase matches and increase the count by 1
  } else {
    $(this).show();
    count++;
  }

});
  setTimeout(() => {
    AOS.init({once: true});
  }, 1000);
// No result Found
if(count == 0){
  $('.noResultFound').show();
}else{
  $('.noResultFound').hide();

}
});
            });


          </script>

          <script>
            window.onscroll = function() {myFunction()};

            var searchbar = document.getElementById("search-body");
            var sticky = searchbar.offsetTop - 67;

            function myFunction() {
              if (window.pageYOffset >= sticky) {
                searchbar.classList.add("sticky-search")
              } else {
                searchbar.classList.remove("sticky-search");
              }
            }
          </script>
          <script>
            setTimeout(function () {

              $('.skeleton').hide();
              $('.lazyImg').show();

            }, 5000);
          </script>
          <div class="blogList">


            @foreach($posts as $post)  

            <div class="blog" href="">
              <div class="blogImg" data-aos-duration="800" data-aos-delay="200" data-aos="fade-up">
                <div class="lazyImgDiv">
                      <?php
                    $logo =\App\Models\Upload::wherePostId($post->id)->whereStatus('1')->first();
                    ?>
                    @if($logo)

  <img class="lazyImg" src="{{ url('/') }}{{ $logo->file_path }}" alt="{{ parentpage($post->parent_page) }}">
                    @endif


                
                  <div style="width: 374px; height: 249px; margin: 0px auto;" class="skeleton"></div>
                </div>
                <!-- <img src="https://www.myperfectpaper.net/" alt="blog Image"> -->
              </div>
              <div class="blogName" data-aos-duration="800" data-aos-delay="200" data-aos="fade-up">
                <h2 data-aos-duration="800" data-aos-delay="200" data-aos="fade-up">



                  @if($post->parent_page == 5)
                  <a href="{{ route('blog_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                  @elseif($post->parent_page == 7)
                  <a href="{{ route('question_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                  @elseif($post->parent_page == 10)
                  <a href="{{ route('sample_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                  @elseif($post->parent_page == 12)
                  <a href="{{ route('programming_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                  @else
                  <a href="{{ route('blog_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                  @endif
                </h2></div>
              </div>
              @endforeach              

            </div>
            <div class="noResultFound">
              <img src="includes/dynamicPages/dynamic-blogs-listing/images/nofound.svg" alt="Result Not Found">
              <h1>Sorry, No results found</h1>
              <p>Please try again with a different search term.</p>
            </div>

          </div>
        </div></section>
<!-- <section class="seoContent">
  <div class="container">
          <div class="seoContentCard">
          <h2>The Ultimate Writing Guide Collection To Improve Your Writing</h2>
          <p>Are you a student struggling with a writing task? Don't worry - you are not alone. Students come across various kinds of writing tasks throughout their careers. And we all know that writing is hard!</p> 
          <p>But there’s no need to worry! We've got a solution for all your writing problems.</p> 
          <p>With the right guidance and support, you can develop key skills that will help you ace your writing. We have comprehensive guides on a wide range of academic topics, so you can write successfully.</p> 
          
           <h2>What are These Guides About?</h2>

          <p>Our guide collection includes detailed guides that cover a variety of subjects, such as essay writing, research papers, dissertations, and more.</p> 
          <p>Each guide provides step-by-step instructions on how to write an effective paper and also offers helpful tips to make the process easier. You will be able to find all the information you need in one place, so there's no need to search through countless websites.</p> 
          
          <h2> How Do These Guides Help?</h2>

          <p> By following the instructions in these guides, you'll be able to become a better writer and increase your chances of getting top grades.</p>
          <p> You'll also gain valuable insights into how to structure and format different types of writing. With such insights, you can create quality academic papers that stand out from the rest.</p>
          <p> In short, our guides will provide you with all the knowledge you need to write great papers!</p>

          <h2> Guides Written By Writing Experts</h2>

          <p> Our guide collection is written by experienced writing experts who have been in the industry for many years. They understand what it takes to write a great paper and are passionate about helping students reach their academic goals.</p>
          <p> So you can be sure these guides will provide you with helpful information that is up-to-date, accurate, and relevant.</p>
          <p> So don't let writing be the barrier between you and success.</p>
          <p> Let our guide collection help you unlock your full academic potential! With these guides, you'll be able to write great papers that are sure to get top grades.</p>


          </div>


  </div>
</section> -->
@endsection