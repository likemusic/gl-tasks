$(document).ready(function () {
    // setup an "add a tag" link
    var addItemLinkContainerSelector = function ($) {
        return $('#task_executors').siblings('label');
    };
    var $addItemLink = $('<a href="#" class="btn btn-primary pull-right">Add executor</a>');
    var $collectionHolder = $('#task_executors');

    $addItemLink.click(function (e) {
        e.preventDefault();
        addItemForm($collectionHolder);
    });


    appendAddItemLink(addItemLinkContainerSelector, $addItemLink);

    var deleteItemContainerSelector = '.form-group';
    var $deleteItemLink = $('<a href="#" class="pull-right">Delete</a>');
    $deleteItemLink.click(function () {
        $(this).parent().remove();
    });

    appendDeleteItemLinks(deleteItemContainerSelector, $deleteItemLink, $collectionHolder);

    function appendAddItemLink(addItemLinkContainerSelector, $addItemLink) {
        var $container = addItemLinkContainerSelector($);
        $container.append($addItemLink);
    }

    function getItemsCount($collectionHolder) {
        return $collectionHolder.children('.form-group').length;
    }

    function addItemForm($collectionHolder) {
        var prototype = $collectionHolder.data('prototype');
        var index = getItemsCount($collectionHolder);
        var newForm = prototype;
        newForm = newForm.replace(/__name__label__/g, index);
        newForm = newForm.replace(/__name__/g, index);
        var $newForm = $(newForm);
        appendDeleteItemLink($newForm, $deleteItemLink);

        $collectionHolder.append($newForm);
    }

    function appendDeleteItemLinks(deleteItemContainerSelector, $deleteItemLink, $collectionHolder) {
        // add a delete link to all of the existing tag form li elements
        $collectionHolder.find(deleteItemContainerSelector).each(function () {
            appendDeleteItemLink($(this), $deleteItemLink);
        });
    }

    function appendDeleteItemLink($item, $deleteItemLink) {
        $item.append($deleteItemLink.clone(true));
    }
});
