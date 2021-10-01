jQuery(document).ready(function($) {
    let searchTimeout = null;

    $(document).on('input', "input[name=search]", function(event) {
        event.preventDefault(); // stopping submitting
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            getSearchData(event);
        }, 600);
    });

    $(document).on('click', ".js-submit", function(event) {
        getSearchData(event);
    });

    function getSearchData(event) {
        $(event.currentTarget).parents('form').find('.sidebar-search-results').remove();

        if ($(event.currentTarget).val().length >= 3) {
            let data = $(event.currentTarget).parents('form').serializeArray();
            let url = $(event.currentTarget).parents('form').attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data
            })
            .done(function (response) {
                if (response.data.length >= 1) {
                    let $wrapper = $('<div class="sidebar-search-results"></div>');
                    $(event.currentTarget).parents('form').append($wrapper);
                    response.data.map(function (item) {
                        $wrapper.append(`<div class="list-group"><a href="#" class="js-autocomplete list-group-item">
                    <span class="search-title">${item.kitchen_name}</span><span class="search-path"></span></a></div>`)
                    });
                }
            })
            .fail(function (response) {
                console.log(response)
            });
        }
    }
});