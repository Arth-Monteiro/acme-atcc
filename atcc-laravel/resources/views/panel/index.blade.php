@extends('layouts.app')

@push('styles_scripts')
    <script>

        const item = {
            page: 1,
            previousPage: 0,
            setPage: function (newPage) {
                this.page = newPage;
            },
            loadCards: function() {
                if (!!this.page && this.page !== this.previousPage) {
                    this.previousPage = this.page;
                    console.log(this.page, this.previousPage)
                    this.url = (this.page === 1) ? window.location.pathname + '/list' : this.page;
                    $.ajax({
                        type: 'GET',
                        // url: "http://localhost:8000/tags/list?page=1&active=1",
                        url: this.url,
                        success: function (response) {
                            item.setPage( response.buildings['next_page_url'] );
                            console.log(response)
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });
                }
            },
        }

        $(document).ready(function() {
            item.loadCards();

            $("#code").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $(".card").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        })

        $(document).scroll(function() {
            if (window.innerHeight + window.scrollY >= parseInt($(this.body).height()) - 300) {
                item.loadCards();
            }
        });

    </script>
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container d-flex justify-content-between" style="border: 1px solid black;">
        <div style="border: 1px solid red;">
            HDASUHDUADs
        </div>
        <div style="border: 1px solid red;">
            JISOJOdiASD
        </div>
        <div style="border: 1px solid red;">
            SJDJAJOSdo
        </div>
        <div style="border: 1px solid red;">
            SJOAIDAOIJSOdi
        </div>
    </div>
@endsection
