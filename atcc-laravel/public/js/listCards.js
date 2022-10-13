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
                this.url = (this.page === 1) ? window.location.pathname + '/list' : this.page;
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
    })
})();
