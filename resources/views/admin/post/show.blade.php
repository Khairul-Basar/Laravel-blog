@extends('layouts.backend.app')

@section('title','Post')

@push('css')



    @endpush


@section('content')
    <div class="container-fluid">

        <a href="{{ route('admin.post.index') }}" class="btn btn-danger waves-effect">BACK</a>

        @if($post->is_approved == false)

            <button type="submit" class="btn btn-success waves-effect pull-right"  onclick="approvePost({{ $post->id }})">
                <i class="material-icons">done</i>
                <span>Approve</span>
            </button>
            <form method="POST" action="{{ route('admin.post.approval',$post->id) }}" id="approval-form"
                  style="display: none;">

                {{ csrf_field() }}
                {{ method_field('PUT') }}

            </form>

        @else
            <button type="submit" class="btn btn-success pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>

        @endif
        <br>
        <br>
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-blue-grey">
                        <h2>
                            {{ $post->title }}
                            <small>Posted By <strong ><a class="col-white bg-deep-purple" href="">{{ $post->user->name }}</a></strong>
                                on {{ $post->created_at->toFormattedDateString() }}</small>
                        </h2>
                    </div>

                    <div class="body col-blue-grey">

                        <strong>
                            {!! $post->body !!}
                        </strong>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-deep-purple">
                        <h2>
                            Categories
                        </h2>
                    </div>

                    <div class="body">

                        @foreach($post->categories as $category)

                            <span class="label bg-deep-purple">{{ $category->name }}</span>

                        @endforeach

                    </div>
                </div>
                <div class="card">
                    <div class="header bg-light-green">
                        <h2>
                            Tags
                        </h2>
                    </div>

                    <div class="body">

                        @foreach($post->tags as $tag)

                            <span class="label bg-light-green">{{ $tag->name }}</span>

                        @endforeach

                    </div>
                </div>
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>
                            Feature Image
                        </h2>
                    </div>

                    <div class="body">

                        <img class="img-responsive thumbnail" src="{{url('storage/post/'. $post->image)}}" alt="">

                    </div>
                </div>
            </div>
        </div>

            <!-- Vertical Layout | With Floating Label -->

    </div>
@endsection

@push('js')

    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- TinyMCE -->
    <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script>

    <!-- sweet alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.17/dist/sweetalert2.all.min.js"></script>


    <script type="text/javascript">

        $(function () {

            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/backend/plugins/tinymce') }}';
        });


        function approvePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You Want To Approve This Post...?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('approval-form').submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your Post is Pending :)',
                        'info'
                    )
                }
            })
        }

    </script>
@endpush
