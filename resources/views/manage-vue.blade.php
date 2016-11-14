<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vue Crud</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

    <div class="container" id="manage-vue" v-cloak>
        <div class="row" style="margin: 30px auto;">
            <div class="col-md-12 margin-tb">
                <div class="pull-left">
                    <h2>Laravel Vue JS Item CRUD</h2>
                </div>
                <div class="pull-right" style="margin-top: 20px;">
                    <button type="button" class="btn btn-success"
                            data-toggle="modal"
                            data-target="#create-item">
                        Create Item
                    </button>
                </div>
            </div>
        </div>

        {{-- Item Listing --}}
        <div class="row">
            <table class="table table-bordered">
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th width="200px">Action</th>
                </tr>
                <tr v-for="(item, index) in items">
                    <td>@{{ item.id }}</td>
                    <td>@{{ item.title }}</td>
                    <td>@{{ item.description }}</td>
                    <td>
                        <button class="btn btn-primary" @click.prevent="editItem(item)">Edit</button>
                        <button class="btn btn-danger" @click.prevent="deleteItem(item, index)">Delete</button>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Pagination --}}
        <nav>
            <ul class="pagination">
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous"
                        @click.prevent="changePage(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#"
                        @click.prevent="changePage(page)">@{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next"
                        @click.prevent="changePage(pagination.current + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Create Item Modal --}}
        <div class="modal fade" id="create-item" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Item</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" v-on:submit.prevent="createItem">

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" class="form-control" v-model="newItem.title" />
                                <span v-if="formErrors['title']" class="error text-danger">@{{ formErrors['title'] }}</span>
                            </div>

                            <div class="form-group">
                                <label for="title">Description:</label>
                                <textarea name="description" class="form-control" v-model="newItem.description"></textarea>
                                <span v-if="formErrors['description']" class="error text-danger">@{{ formErrors['description'] }}</span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Item Modal --}}
        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
                    </div>
                    <div class="modal-body">

                        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" class="form-control" v-model="fillItem.title" />
                                <span v-if="formErrorsUpdate['title']" class="error text-danger">@{{ formErrorsUpdate['title'] }}</span>
                            </div>

                            <div class="form-group">
                                <label for="title">Description:</label>
                                <textarea name="description" class="form-control" v-model="fillItem.description"></textarea>
                                <span v-if="formErrorsUpdate['description']" class="error text-danger">@{{ formErrorsUpdate['description'] }}</span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/app.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>
    <script type="text/javascript" src="/js/item.js"></script>
</body>
</html>