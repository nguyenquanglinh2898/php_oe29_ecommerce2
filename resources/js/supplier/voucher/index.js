$('#search-input input').on('keyup', function() {
    table.search(this.value).draw();
});
