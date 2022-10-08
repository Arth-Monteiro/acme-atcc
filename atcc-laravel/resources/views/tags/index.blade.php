@extends('layouts.app')

@push('styles_scripts')

    <script src="{{ asset('js/list.js') }}"></script>
    <script>
        (() => {
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
                        this.url = (this.page === 1) ? ' {{route('list_tags') }} ' : this.page;
                        $.ajax({
                            type: 'GET',
                            // url: "http://localhost:8000/tags/list?page=1&active=1",
                            url: this.url,
                            success: function (response) {
                                item.setPage( response.next['next_page_url'] );
                                $('.card-container').append(response.html);
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
            })

            $(document).scroll(function() {
                if (window.innerHeight + window.scrollY >= parseInt($(this.body).height()) - 300) {
                    item.loadCards();
                }
            })
        })();

    </script>

    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="code" type="text" class="form-control w-25" name="code" autofocus placeholder="Search by CODE...">
            <a class="register-button" href="{{ route('view_create_tag') }}">{{ __('Register Tag') }}</a>
        </div>

        <div class="infinite-scroll">
            <div class="card-container">
            </div>
        </div>
    </div>
@endsection


