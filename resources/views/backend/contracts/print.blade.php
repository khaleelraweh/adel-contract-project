@extends('layouts.print')

@section('content')
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {!! $document->doc_content !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.print();
    </script>
@endsection
