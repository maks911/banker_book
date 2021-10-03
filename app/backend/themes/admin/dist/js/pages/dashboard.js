jQuery(document).ready(function($) {
    let searchTimeout = null;
    let tagsSelector = 'tag-input';

    if ($(`#${tagsSelector}`).length > 0) {
        let tagInput = new TagsInput({
            selector: 'tag-input',
        });
        let $tagInput = $('#tag-input');
        if ($tagInput.val().length > 0) {
            let data = $tagInput.val().split(',');
            console.log(data);
            tagInput.addData(data);
        }
    }

    $(document).on('input', "input[name=search]", function(event) {
        event.preventDefault(); // stopping submitting
        $(event.currentTarget).parents('form').find('.sidebar-search-results').remove();
        if ($(event.currentTarget).val().length >= 3) {
            $(event.currentTarget).parents('.input-group').removeClass('error');
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                getSearchData(event);
            }, 600);
        } else {
            $(event.currentTarget).parents('.input-group').addClass('error');
        }
    });

    $(document).on('click', ".js-search", function(event) {
        $(event.currentTarget).parents('form').find('.sidebar-search-results').remove();
        $(event.currentTarget).parents('form').toggleClass('sidebar-search-open');
        if ($(event.currentTarget).parents('form').find('input[name=search]').val().length >= 3) {
            $(event.currentTarget).parents('.input-group').removeClass('error');
            getSearchData(event);
        } else {
            $(event.currentTarget).parents('.input-group').addClass('error');
        }
    });
    $(document).on('click', ".js-delete", function(event) {
        if (confirm($(this).data('message'))) {
            deleteData(event);
        }
    });

    $(document).on('click', ".js-submit", function(event) {
        $(this).parents('form').submit();
    });

    $(document).on('click', ".js-autocomplete", function(event) {
        let text = $(this).find('.search-title').text();
        let $form = $(this).parents('form');
        $form.find('input[name="search"]').val(text);
        $form.find('.sidebar-search-results').remove();
    });

    function getSearchData(event) {
        let data = $(event.currentTarget).parents('form').serializeArray();
        let url = $(event.currentTarget).parents('form').attr('action');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: data
        })
        .done(function (response) {
            if (response.data && response.data.length >= 1) {
                let $wrapper = $('<div class="sidebar-search-results"><div class="list-group"></div></div>');
                $(event.currentTarget).parents('form').append($wrapper);
                response.data.map(function (item) {
                    $wrapper.append(`<a href="#" class="js-autocomplete list-group-item">
                                     <span class="search-title">${item.kitchen_name}</span>
                                     <span class="search-path"></span>
                                     </a>`)
                });
            }
        })
        .fail(function (response) {
            console.log(response)
        });
    }

    function deleteData(event) {
        let $btn = $(event.currentTarget);
        let url = $btn.attr('data-action');
        let id = $btn.attr('data-id');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {valid: true, id: id}
        })
        .done(function (response) {
            if (response.success) {
                $btn.parents('.row').remove();
            }
        })
        .fail(function (response) {
            console.log(response)
        });
    }
});