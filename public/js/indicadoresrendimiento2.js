$(document).ready(function () {
    $('.expandable-cell').mouseenter(function () {
        var detailsContainer = $(this).find('.details-container');
        detailsContainer.slideDown();
    });

    $('.expandable-cell').mouseleave(function () {
        var detailsContainer = $(this).find('.details-container');
        detailsContainer.slideUp();
    });
});


function OpenGrafics(url) {

    var newWindow = window.open(url, '_blank', 'width=600, height=400');
    
    newWindow.onload = function() {
        form.target = '_blank';
        form.submit();
    };
}

function OpenTables(url) {

    var newWindow = window.open(url, '_blank', 'width=850, height=400');
    
    newWindow.onload = function() {
        form.target = '_blank';
        form.submit();
    };
}

