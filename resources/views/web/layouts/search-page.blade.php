@extends('web.layouts.app')

@section('contents')
    <div class="py-4"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8 col-sm-12">
                    <div class="widget">
                        <h4 class="widget-title"><span>Search</span></h4>
                        <form action="#!" class="widget-search">
                            <input class="mb-3 form-control" id="search-query" name="search_terms" type="search"
                                placeholder="Type & Hit Enter...">
                            <i class="ti-search"></i>
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </form>
                    </div>
                </div>
                <div id="search-results">

            </div>

        </div>
    </section>
@endsection
