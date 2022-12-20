jQuery(document).ready(function () {
    $('.filters').on('change', 'input, select', function () {
        let filtersDiv = $('.filters');
        let url = new URL(filtersDiv.data('url'));
        let params = filtersDiv.find('input, select').serializeArray();
        for (const element of params) {
            url.searchParams.append(element.name, element.value);
        }
        location.href = url.href;
    });
});
