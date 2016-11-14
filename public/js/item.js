Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

new Vue({
    el: '#manage-vue',
    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 10,
            from: 1,
            to: 0,
            current_page: 1
        },
        itemCount: 0,
        offset: 4,
        formErrors: {},
        formErrorsUpdate: {},
        newItem: { 'title': '', 'description': '' },
        fillItem: { 'title': '', 'description': '', 'id': '' }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }

            return pagesArray;
        }
    },
    mounted: function() {
        this.getVueItems(this.pagination.current_page);
    },
    methods: {
        getVueItems: function (page) {
            var vm = this;
            this.$http.get('/items?page=' + page).then((response) => {
                vm.items = response.data.data.data;
                vm.pagination = response.data.pagination;
            }, (response) => {
                console.log("error here");
            });
        },

        createItem: function () {
            var input = this.newItem;
            var vm = this;
            this.$http.post('/items', input).then((response) => {
                vm.changePage(vm.pagination.current_page);
                // vm.items.unshift({  'title': 'hello',
                //                     'description': response.data.description,
                //                     'id': response.data.id });
                vm.newItem = { 'title': '', 'description': '' };
                $('#create-item').modal('hide');
                toastr.success('Item created successfully.', 'Success Alert', {timeOut: 3000});
            }, (response) => {
                this.formErrors = response.data;
            });
        },

        editItem: function (item) {
            this.fillItem.title = item.title;
            this.fillItem.id = item.id;
            this.fillItem.description = item.description;
            $('#edit-item').modal('show');
        },

        updateItem: function (id) {
            var input = this.fillItem;
            var vm = this;
            this.$http.put('/items/' + id, input).then((response) => {
                vm.changePage(vm.pagination.current_page);
                vm.fillItem = { 'title': '', 'description': '', 'id': '' };
                $('#edit-item').modal('hide');
                toastr.info('Item updated successfully.', 'Update Alert', {timeOut: 3000})
            }, (response) => {
                this.formErrorsUpdate = response.data;
            });
        },

        deleteItem: function (item, index) {
            var vm = this;
            this.$http.delete('/items/' + item.id).then((response) => {
                // vm.changePage(this.pagination.current_page);
                vm.items.splice(index, 1);
                toastr.warning('Item Deleted Successfullly.', 'Delete Alert', {timeOut: 3000});
            });
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
    }
});