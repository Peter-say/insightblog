@extends('web.layouts.app')

@section('contents')
<div class="py-4"></div>
<section class="section">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Search</h4>
                    </div>
                    <div class="card-body">
                        <form action="#!" class="widget-search">
                            <div class="form-group">
                                <input class="form-control mb-3" id="search-query" name="search_terms" type="search"
                                    placeholder="Type & Hit Enter...">
                                <i class="ti-search"></i>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-lg-8 col-sm-12">
                <div id="search-results"></div>
            </div>
        </div>
    </div>
</section>
@endsection
