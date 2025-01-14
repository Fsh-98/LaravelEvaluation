@extends('layouts.app')

@section('content')

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  </head>
  <body>
    <center>
        <div class="container">
            <h3>Product View List</h3>
            <form class="mr-3 mt-3" style="float: left" method="GET">
                <label for="price_range"><b>Price Range</b></label>            
                <div class="input-group">
                    <input id="min" name="min_value" size="30" required type="number" />
                    <input id="max" name="max_value" size="30" required type="number" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>

            </form>
            <form class="mr-3 mt-3" style="float: right" method="GET">
                <label for="price_range"><b>Search by title</b></label>
                <div class="input-group">
                    <input type="text" class="form-control table_search" name="search" placeholder="Search" required value="{{ request()->get('search') }}" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <div class="mr-3 mt-3">
                <a href="{{ route('home') }}" class="btn btn-warning reset" type="button">Reset</a>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                        Add Product
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Enter Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('add-product') }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="text" placeholder="Enter Title" required name="title" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" placeholder="Enter Description" name="description" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <input type="number" placeholder="Enter Subcategory ID" name="subcategory" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <input type="number" placeholder="Enter Price" required name="price" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <input type="file" placeholder="Enter Thumbnail" required name="thumbnail" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container mt-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle btn-sm" id="dropdownMenuButtonCategory" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Category
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCategory">
                    @foreach ($categories as $category)
                        <form>
                            <input type="text" name="category" hidden value="{{$category->title}}">
                            <button class="btn dropdown-item btn-light">{{$category->title}}</button>
                        </form>
                    @endforeach
    
                </div>
            </div>
            <div class="dropdown mt-4">
                <button class="btn btn-primary dropdown-toggle btn-sm" id="dropdownMenuButtonSubcategory" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Subcategory
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSubcategory">
                    @foreach ($subcategories as $subcategory)
                        <form>
                            <input type="text" name="subcategory" hidden value="{{$subcategory->title}}">
                            <button class="btn dropdown-item btn-light">{{$subcategory->title}}</button>
                        </form>
                    @endforeach
    
                </div>
            </div>
        </div>

        <div class="container">
            <table class="table mt-5">
                <thead>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Price</th>
                    <th>Operate</th>
                </thead>
                <tbody>
                    @forelse ($products as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td><img src="{{$item->thumbnail}}" width="100px" height="100px" alt=""></td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->description ?? N/A}}</td>
                            <td>{{$item->subcategory->category->title ?? N/A}}</td>
                            <td>{{$item->subcategory->title ?? N/A}}</td>
                            <td>{{$item->price}}</td>
                            <td>
                                <form action="{{ route('delete-product', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" align="center" style="color: #AA7777;">No products found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="float: right">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </center>

    <script>
        $('.reset').on('click', function() {
          
          $("input[name=search]").val('');
      });
    </script>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>

</html>

@endsection


