$(function() {

    $.ajax({
        type: "GET",
        url: "http://3.144.129.225/scrap/sourcecodester/data/"
    }).done(function(countries) {

        /*countries.unshift({ id: "0", name: "" });*/

        $("#jsGrid").jsGrid({
            height: "100%",
            width: "100%",
            filtering: true,
            inserting: false,
            editing: false,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            deleteConfirm: "Do you really want to delete client?",
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "GET",
                        url: "http://3.144.129.225/scrap/sourcecodester/data",
                        data: filter
                    });
                },
                insertItem: function(item) {

                },
                updateItem: function(item) {

                },
                deleteItem: function(item) {

                }
            },
            fields: [
                /*{ name: "id", title: "Id", type: "text", width: 150 },
                { name: "client_id", title: "client_id", type: "text", width: 50, filtering: true },*/
                { name: "views", title: "views", type: "text", width: 200 },
                { name: "title", title: "title", type: "text", width: 500 },
                { name: "short_description", title: "short_description", type: "text", width: 500 },
                { name: "url", title: "url", type: "text", width: 500 },/*
                { name: "image", title: "image", type: "text", width: 500 },
                { type: "control" }*/
            ]
        });

    });

});
