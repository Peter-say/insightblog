@extends('web.layouts.app')

@section('contents')
    <div class="py-4"></div>
    <div class="container">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-lg-10 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="card-title">Search</h4>
                    </div>
                    <div class="card-body">
                        <form action="#!" class="widget-search">
                            <div class="form-group">
                                <input class="form-control mb-3" id="search-query" name="search_terms" type="search"
                                    placeholder="Type & Hit Enter...">
                                <i class="ti-search" ></i>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

       <div id="search-results"></div>
        
    </div>
@endsection
