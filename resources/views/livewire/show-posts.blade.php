
<!-- ROW-8 OPEN -->
<div class="section bg-landing" id="Blog">
    <div class="container">
        <div class="row">
            <h4 class="text-center fw-semibold">Blog Posts </h4>
            <span class="landing-title"></span>
            <h2 class="text-center fw-semibold mb-7">Latest from Blog.</h2>


            @foreach ($posts as $post)


            <div class="col-lg-6">
                <div class="card bg-transparent reveal">
                    <div class="card-body px-1">
                        <div class="d-flex overflow-visible">
                            <a href="blog-details.html"
                            class="card-aside-column br-5 cover-image"
                            data-bs-image-src="../assets/images/media/12.jpg"
                            style="background: url(&quot;../assets/images/media/12.jpg&quot;) center center;"></a>
                            <div class="ps-3 flex-column">
                                <span
                                class="badge bg-primary me-1 mb-1 mt-1">Business</span>
                                <h3><a href="blog-details.html">{{ $post->title }}</a></h3>
                                <div class="">Excepteur sint occaecat cupidatat non
                                    proident, accusantium sunt in culpa qui officia deserunt
                                mollit anim id est laborum....</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach





            <div class="text-center">
                <a href="blog.html" target="_blank"
                class="btn btn-outline-primary pt-2 pb-2"><i
                class="fe fe-arrow-right me-2"></i>Discover More
            </a>
        </div>
    </div>
</div>
</div>
                            <!-- ROW-8 CLOSED -->